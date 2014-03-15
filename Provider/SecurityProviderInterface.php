<?php

namespace Nazka\AttachmentBundle\Provider;

use Nazka\AttachmentBundle\Model\HasAttachmentsInterface;
use Nazka\AttachmentBundle\Model\AttachmentInterface;

/**
 * @author javier
 */
interface SecurityProviderInterface
{
    public function getAttachments(HasAttachmentsInterface $owner);

    public function hasItemAccess(HasAttachmentsInterface $owner, AttachmentInterface $attachment);

    public function hasCollectionAccess(HasAttachmentsInterface $owner);
    
    /**
     * Return a key => label array with available access modes
     */
    public function getAccessModes();
}
