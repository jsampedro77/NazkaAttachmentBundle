<?php

namespace Nazka\AttachmentBundle\Twig;

use Nazka\AttachmentBundle\Entity\Attachment;

/**
 *
 * @author Javier Sampedro <jsampedro77@gmail.com>
 */
class AttachmentExtension extends \Twig_Extension
{

    private $webPath;

    public function setWebPath($webPath)
    {
        $this->webPath = $webPath;
    }

    public function getFilters()
    {
        return array(
            'attachment_thumbnail' => new \Twig_Filter_Method($this, 'attachmentThumbnail', array(
                'is_safe' => array('html')
                    ))
        );
    }

    public function attachmentThumbnail(Attachment $attachment)
    {
        if ($attachment->getThumbnail()) {
            $src = $attachment->getThumbnail();
        } else {
            $filename = $this->fileExtension($attachment->getFileName()) . ".png";
            $assetsPath = '/bundles/nazkaattachment/img/';

            if (!file_exists($this->webPath . $assetsPath . $filename)) {
                $filename = 'missing.png';
            }

            $src = $assetsPath . $filename;
        }

        return sprintf("<img src='%s' class='thumbnail'/>", $src);
    }

    public function getName()
    {
        return 'nazka_attachment_extension';
    }

    private function fileExtension($filename)
    {
        return strtolower(substr(strrchr($filename, '.'), 1));
    }
}
