<?php

namespace Nazka\AttachmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Attachable
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Attachable
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\OneToMany(targetEntity="Attachment", mappedBy="attachable", cascade={"all"}, orphanRemoval=true)
     * @var type 
     */
    protected $attachments;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated_at;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attachments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add attachments
     *
     * @param \Nazka\AttachmentBundle\Entity\Attachment $attachments
     * @return Attachable
     */
    public function addAttachment(\Nazka\AttachmentBundle\Entity\Attachment $attachments)
    {
        $this->attachments[] = $attachments;
        $attachments->setAttachable($this);

        return $this;
    }

    /**
     * Remove attachments
     *
     * @param \Nazka\AttachmentBundle\Entity\Attachment $attachments
     */
    public function removeAttachment(\Nazka\AttachmentBundle\Entity\Attachment $attachment)
    {
        $this->attachments->removeElement($attachment);
        $attachment->setAttachable(null);
    }

    /**
     * Get attachments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Attachable
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}
