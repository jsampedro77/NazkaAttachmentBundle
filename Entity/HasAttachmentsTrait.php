<?php

namespace Nazka\AttachmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait to include common methods of an entity with attachments
 *
 * @author Javier Sampedro <jsampedro77@gmail.com>
 */
trait HasAttachmentsTrait
{

    /**
     * @ORM\OneToOne(targetEntity="Nazka\AttachmentBundle\Entity\Attachable", cascade={"all"})
     * @ORM\JoinColumn(name="attachable_id", referencedColumnName="id", nullable=true)
     */
    private $attachable;

    /**
     * @return Attachable
     */
    public function getAttachable()
    {
        if (!$this->attachable) {
            $this->setAttachable(new Attachable());
        }

        return $this->attachable;
    }

    public function setAttachable(Attachable $attachable)
    {
        $this->attachable = $attachable;
    }

    /**
     * Add attachments
     *
     * @param \Nazka\AttachmentBundle\Model\AttachmentInterface $attachments
     * @return Attachable
     */
    public function addAttachment(\Nazka\AttachmentBundle\Model\AttachmentInterface $attachment)
    {
        $this->getAttachable()->addAttachment($attachment);
        
        return $this;
    }

    /**
     * Remove attachments
     *
     * @param \Nazka\AttachmentBundle\Model\AttachmentInterface $attachments
     */
    public function removeAttachment(\Nazka\AttachmentBundle\Model\AttachmentInterface $attachment)
    {
        $this->getAttachable()->removeAttachment($attachment);
    }

    /**
     * Get attachments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAttachments()
    {
        return $this->getAttachable()->getAttachments();
    }
}
