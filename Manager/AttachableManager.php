<?php

namespace Nazka\AttachmentBundle\Manager;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Nazka\AttachmentBundle\Helper\Tools;
use Nazka\AttachmentBundle\Entity\Attachable;
use Nazka\AttachmentBundle\Model\HasAttachmentsInterface;
use Nazka\AttachmentBundle\Factory\SecurityProviderFactory;
use Nazka\AttachmentBundle\Model\AttachmentInterface;

/**
 * Description of AttachmentManager
 *
 * @author javier
 */
class AttachableManager
{

    protected $repository;
    protected $em;
    protected $securityFactory;
    protected $attachmentManager;

    public function __construct(EntityRepository $repository, EntityManager $em, SecurityProviderFactory $securityFactory, AttachmentManager $attachmentManager)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->securityFactory = $securityFactory;
        $this->attachmentManager = $attachmentManager;
    }

    /**
     * 
     * @param type $id
     * @return  \Nazka\AttachmentBundle\Entity\Attachable
     * @throws Exception
     * 
     */
    public function find($id)
    {
        $attachment = $this->repository->find($id);

        if (!$attachment) {
            throw new Exception('Attachable not found');
        }

        return $attachment;
    }

    public function getAttachments(Attachable $attachable)
    {
        $owner = $this->findOwner($attachable);
        if (!$owner) {
            throw new \RuntimeException('Could not find Attachment collection owner');
        }

        return $this->getAttachmentsSecurityProvider($owner)->getAttachments($owner);
    }

    public function addAttachments(Attachable $attachable, $attachments)
    {
        $this->checkCollectionAccess($attachable);

        foreach ($attachments as $attachment) {
            if ($attachment->getFile()) {
                $attachable->addAttachment($attachment);
            }
        }

        $this->em->persist($attachable);
        $this->em->flush();

        return $attachable;
    }

    public function downloadAttachmentById($attachmentId)
    {
        $attachment = $this->attachmentManager->find($attachmentId);

        return $this->downloadAttachment($attachment);
    }

    public function downloadAttachment(AttachmentInterface $attachment)
    {
        $this->checkItemAccess($attachment);

        return $this->attachmentManager->downloadAttachment($attachment);
    }

    public function checkCollectionAccess(Attachable $attachable)
    {
        $owner = $this->findOwner($attachable);

        if (!$this->getAttachmentsSecurityProvider($owner)->hasCollectionAccess($owner)) {
            throw new AccessDeniedHttpException('Can not access attachment collection resource');
        }
    }

    public function checkItemAccess(AttachmentInterface $attachment)
    {
        $owner = $this->findOwner($attachment->getAttachable());

        if (!$this->getAttachmentsSecurityProvider($owner)->hasItemAccess($owner, $attachment)) {
            throw new AccessDeniedHttpException('Can not access attachment resource');
        }
    }
    
    private function findOwner(Attachable $attachable)
    {
        foreach (Tools::getImplementingClasses('Nazka\AttachmentBundle\Model\HasAttachmentsInterface') as $ownerClass) {
            $qb = $this->em->createQueryBuilder()
                    ->select('oc')
                    ->from($ownerClass, 'oc')
                    ->where('oc.attachable = :attachable')
                    ->setParameter('attachable', $attachable);

            if ($owner = $qb->getQuery()->getOneOrNullResult()) {
                return $owner;
            }
        }

        return false;
    }

    private function getAttachmentsSecurityProvider(HasAttachmentsInterface $owner)
    {
        return $this->securityFactory->getProviderByEntity($owner);
    }
}
