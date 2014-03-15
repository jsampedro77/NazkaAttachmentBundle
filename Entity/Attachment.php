<?php

namespace Nazka\AttachmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;
use Nazka\AttachmentBundle\Model\AttachmentInterface;
use Nazka\AttachmentBundle\Enum\AccessEnum;

/**
 * Attachment
 *
 * @ORM\Table()
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Attachment implements AttachmentInterface
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
     * @ORM\ManyToOne(targetEntity="Attachable", inversedBy="attachments")
     * @var type 
     */
    protected $attachable;

    /**
     * @Assert\File(
     *     maxSize="20M"
     * )
     * @Vich\UploadableField(mapping="attachment", fileNameProperty="fileName")
     *
     * @var File $file
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255, name="file_name", nullable=true)
     *
     * @var string $fileName
     */
    protected $fileName;

    /**
     * @ORM\Column(type="string", length=255, name="original_file_name", nullable=true)
     *
     * @var string $originalFileName
     */
    protected $originalFileName;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="Symfony\Component\Security\Core\User\UserInterface")
     */
    private $created_by;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated_at;

    /**
     * @var mimeType 
     * @ORM\Column(name="mime_type", type="string", length=128)
     */
    private $mimeType;

    /**
     * @var thumbnail
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var thumbnail
     * @ORM\Column(name="thumbnail", type="text", nullable=true)
     */
    private $thumbnail;

    /**
     * @var size 
     * @ORM\Column(name="size", type="integer")
     */
    private $size;

    /**
     * @var size 
     * @ORM\Column(name="access", type="integer")
     */
    private $access;

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
     * Set fileName
     *
     * @param string $fileName
     * @return MachineDocument
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string 
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return MachineDocument
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return MachineDocument
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

    /**
     * Set file
     *
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set attachable
     *
     * @param \Nazka\AttachmentBundle\Entity\Attachable $attachable
     * @return Attachment
     */
    public function setAttachable(\Nazka\AttachmentBundle\Entity\Attachable $attachable = null)
    {
        $this->attachable = $attachable;

        return $this;
    }

    /**
     * Get attachable
     *
     * @return \Nazka\AttachmentBundle\Entity\Attachable 
     */
    public function getAttachable()
    {
        return $this->attachable;
    }

    public function __toString()
    {
        return $this->getFileName()? : '---';
    }

    /**
     * Set mimeType
     *
     * @param string $mimeType
     * @return Attachment
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string 
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     * @return Attachment
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string 
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Set size
     *
     * @param integer $size
     * @return Attachment
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Attachment
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set access
     *
     * @param integer $access
     * @return Attachment
     */
    public function setAccess($access)
    {
        $this->access = $access;

        return $this;
    }

    /**
     * Get access
     *
     * @return integer 
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * Set created_by
     *
     * @param \Symfony\Component\Security\Core\User\UserInterface $createdBy
     * @return Attachment
     */
    public function setCreatedBy(\Symfony\Component\Security\Core\User\UserInterface $createdBy = null)
    {
        $this->created_by = $createdBy;

        return $this;
    }

    /**
     * Get created_by
     *
     * @return \Symfony\Component\Security\Core\User\UserInterface 
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    public function getCreatedByLabel()
    {
        return (string) $this->getCreatedBy();
    }

    /**
     * Set originalFileName
     *
     * @param string $originalFileName
     * @return Attachment
     */
    public function setOriginalFileName($originalFileName)
    {
        $this->originalFileName = $originalFileName;
    
        return $this;
    }

    /**
     * Get originalFileName
     *
     * @return string 
     */
    public function getOriginalFileName()
    {
        return $this->originalFileName;
    }
}