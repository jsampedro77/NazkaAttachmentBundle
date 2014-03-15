<?php

namespace Nazka\AttachmentBundle\Provider;

use Nazka\AttachmentBundle\Model\HasAttachmentsInterface;
use Nazka\AttachmentBundle\Model\AttachmentInterface;
use Nazka\AttachmentBundle\Enum\AccessEnum;

/**
 * @author javier
 */
class NullSecurityProvider implements SecurityProviderInterface
{

    public function getAttachments(HasAttachmentsInterface $owner)
    {
        return $owner->getAttachments();
    }

    public function hasCollectionAccess(HasAttachmentsInterface $owner)
    {
        return true;
    }

    public function hasItemAccess(HasAttachmentsInterface $owner, AttachmentInterface $attachment)
    {
        return true;
    }

    public function getAccessModes()
    {
        return AccessEnum::humanizedValues();
    }
}
