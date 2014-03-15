<?php

namespace Nazka\AttachmentBundle\Generator;

use \Symfony\Component\HttpFoundation\File\File;

/**
 * Description of ThumbnailGenerator
 *
 * @author javier
 */
class VideoThumbnailGenerator implements ThumbnailGeneratorInterface
{

    protected $ffmpeg;

    public function __construct($ffmpeg)
    {
        $this->ffmpeg = $ffmpeg;
    }

    public function thumbnail(File $file)
    {

        //no ffmpeg bin provided, no thumbnail will be created
        if(!$this->ffmpeg){
            return null;
        }
        
        if (!\file_exists($this->ffmpeg)) {
            throw new \Exception(sprintf('FFMPEG not found at %s. Can not generate video thumbnail', $this->ffmpeg));
        }

        $video = $file->getPathname();
        $image = $file->getPathname() . '.png';

        $second = 1;
        $cmd = "$this->ffmpeg -i $video 2>&1";

        if (preg_match('/Duration: ((\d+):(\d+):(\d+))/s', `$cmd`, $time)) {
            $total = ($time[2] * 3600) + ($time[3] * 60) + $time[4];
            $second = rand(1, ($total - 1));
        }

        $cmd = "$this->ffmpeg -i $video -deinterlace -an -ss $second -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $image 2>&1";

        $ret = `$cmd`;

        return $image;
    }
}
