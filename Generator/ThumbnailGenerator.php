<?php

namespace Nazka\AttachmentBundle\Generator;

use \Symfony\Component\HttpFoundation\File\File;
use Intervention\Image\Image;
use Nazka\AttachmentBundle\Manager\FormatManager;

/**
 * Description of ThumbnailGenerator
 *
 * @author javier
 */
class ThumbnailGenerator implements ThumbnailGeneratorInterface
{

    protected $videoThumbnailGenerator;
    protected $formatManager;

    public function __construct(ThumbnailGeneratorInterface $videoThumbnailGenerator, FormatManager $formatManager)
    {
        $this->videoThumbnailGenerator = $videoThumbnailGenerator;
        $this->formatManager = $formatManager;
    }

    public function thumbnail(File $file)
    {
        if ($this->isImage($file)) {

            return $this->createImageThumbnail($file);
        } elseif ($this->isVideo($file)) {

            $videoThumbImage = $this->videoThumbnailGenerator->thumbnail($file);
            
            return $videoThumbImage?$this->createImageThumbnailFromPath($videoThumbImage):null;
        } else {

            return null;
        }
    }

    protected function createImageThumbnail(File $file)
    {
        if (!$this->isImage($file)) {
            throw new \ErrorException('File is not an image, can not create thumbnail');
        }

        return $this->createImageThumbnailFromPath($file->getPathname());
    }

    protected function createImageThumbnailFromPath($filepath)
    {

        $image = Image::make($filepath)->resize(120, 120);
        return $image->encode('data-url');
    }

    private function isImage(File $file)
    {
        $mime = $file->getMimeType();
        $filename = $file->getBasename();

        return $this->formatManager->isImage($mime, $filename);
    }

    private function isVideo(File $file)
    {
        $mime = $file->getMimeType();
        $filename = $file->getBasename();

        return $this->formatManager->isVideo($mime, $filename);
    }
}
