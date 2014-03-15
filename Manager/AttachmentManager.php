<?php

namespace Nazka\AttachmentBundle\Manager;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Vich\UploaderBundle\Storage\StorageInterface;
use Nazka\AttachmentBundle\Model\AttachmentInterface;
use Nazka\AttachmentBundle\Manager\FormatManager;
use Nazka\AttachmentBundle\Helper\Tools;

/**
 * Description of AttachmentManager
 *
 * @author javier
 */
class AttachmentManager
{

    protected $repository;
    protected $storage;
    protected $formatManager;

    public function __construct(EntityRepository $repository, StorageInterface $storage, FormatManager $formatManager)
    {
        $this->repository = $repository;
        $this->storage = $storage;
        $this->formatManager = $formatManager;
    }

    public function download($id)
    {
        $attachment = $this->find($id);

        return $this->downloadAttachment($attachment);
    }

    public function downloadAttachment(AttachmentInterface $attachment)
    {
        $file = $this->storage->resolvePath($attachment, 'file');
        $response = new BinaryFileResponse($file);
        $response->setContentDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT, Tools::cleanUTF8String($attachment->getOriginalFileName())
        );

        return $response;
    }

    public function isImage(AttachmentInterface $attachment)
    {
        return $this->formatManager->isImage($attachment->getMimeType(), $attachment->getFileName());
    }

    public function isVideo(AttachmentInterface $attachment)
    {
        return $this->formatManager->isVideo($attachment->getMimeType(), $attachment->getFileName());
    }

    /**
     * 
     * @param type $id
     * @return  \Nazka\AttachmentBundle\Entity\Attachment
     * @throws Exception
     * 
     */
    public function find($id)
    {
        $attachment = $this->repository->find($id);

        if (!$attachment) {
            throw new Exception('Attachment not found');
        }

        return $attachment;
    }
}
