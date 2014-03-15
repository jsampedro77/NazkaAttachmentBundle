<?php

namespace Nazka\AttachmentBundle\Model;

use Nazka\AttachmentBundle\Entity\Attachable;
use Nazka\AttachmentBundle\Model\AttachmentInterface;

/**
 * Description of HasAttachmentsInterface
 *
 * @author javier
 */
interface HasAttachmentsInterface
{

    public function getAttachable();

    public function setAttachable(Attachable $attachable);

    public function addAttachment(AttachmentInterface $attachment);

    public function removeAttachment(AttachmentInterface $attachment);

    public function getAttachments();
}
