<?php

namespace Nazka\AttachmentBundle\Storage;

use Vich\UploaderBundle\Storage\GaufretteStorage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Nazka\AttachmentBundle\Model\AttachmentInterface;
use Nazka\AttachmentBundle\Generator\ThumbnailGeneratorInterface;
use Gaufrette\StreamWrapper;

/**
 * Description of VichStorage
 *
 * @author javier
 */
class VichGaufretteStorage extends GaufretteStorage
{

    protected $thumbnailGenerator;

    public function upload($obj)
    {
        parent::upload($obj);

        if ($obj instanceof AttachmentInterface) {

            $mappings = $this->factory->fromObject($obj);
            foreach ($mappings as $mapping) {
                $file = $mapping->getPropertyValue($obj);
                if (is_null($file) || !($file instanceof UploadedFile)) {
                    continue;
                }

                $this->completeFileInfo($obj, $file);
            }
        }
    }


    public function doResolvePath($dir, $name)
    {
        $map = StreamWrapper::getFilesystemMap();
        $filesystem = $this->getFilesystem($dir);
        $map->set('attachment_fs', $filesystem);
        StreamWrapper::register();

        return parent::doResolvePath($dir, $name);
    }

    public function setThumbnailGenerator(ThumbnailGeneratorInterface $thumbnailGenerator)
    {
        $this->thumbnailGenerator = $thumbnailGenerator;
    }

    /**
     * Completes attachment info (size, mime_type and thumbnail)
     * 
     * @param \Nazka\AttachmentBundle\Storage\AttachmentInterface $attachment
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     */
    protected function completeFileInfo(AttachmentInterface $attachment, UploadedFile $file)
    {
        $attachment->setSize($file->getSize());
        $attachment->setMimeType($file->getMimeType());
        $attachment->setThumbnail($this->createThumbnail($file));
        $attachment->setOriginalFilename($file->getClientOriginalName());
    }

    protected function createThumbnail(UploadedFile $file)
    {
        return $this->thumbnailGenerator->thumbnail($file);
    }
}
