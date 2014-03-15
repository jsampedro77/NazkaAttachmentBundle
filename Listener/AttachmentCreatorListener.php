<?php

namespace Nazka\AttachmentBundle\Listener;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Doctrine\Common\EventArgs;
use Nazka\AttachmentBundle\Entity\Attachment;

/**
 * Description of AttachmentOwnerListener
 *
 * @author javier
 */
class AttachmentCreatorListener
{

    protected $securityContext;

    public function __construct(SecurityContextInterface $securityContext)
    {
     $this->securityContext = $securityContext;   
    }

    public function prePersist(EventArgs $args)
    {
        if (PHP_SAPI === 'cli') {
            return;
        }

        $entity = $args->getEntity();
        if ($entity instanceof Attachment) {
            $entity->setCreatedBy($this->securityContext->getToken()->getUser());
        }
    }
}
