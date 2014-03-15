<?php

namespace Nazka\AttachmentBundle\Manager;

use Symfony\Component\HttpFoundation\File\File;

/**
 * Description of FormatManager
 *
 * @author javier
 */
class FormatManager
{

    const UNKNOW = 'unknown';
    const VIDEO = 'video';
    const IMAGE = 'image';
    const PDF = 'pdf';

    protected $mimes = array(
        self::IMAGE => array(
            'image/gif' => 'gif',
            'image/jpeg' => 'jpeg',
            'image/png' => 'png',
            'image/psd' => 'psd',
            'image/bmp' => 'bmp',
            'image/tiff' => 'tiff',
            'image/tiff' => 'tiff',
            'image/jp2' => 'jp2',
            'image/iff' => 'iff',
            'image/vnd.wap.wbmp' => 'bmp',
            'image/xbm' => 'xbm'
        ),
        self::VIDEO => array(
            'video/3gpp' => '3gp',
            'video/3gpp2' => '3g2',
            'video/h261' => 'h261',
            'video/h263' => 'h263',
            'video/h264' => 'h264',
            'video/jpeg' => 'jpgv',
            'video/jpm' => 'jpm',
            'video/mj2' => 'mj2',
            'video/mp4' => 'mp4',
            'video/mpeg' => 'mpeg',
            'video/ogg' => 'ogv',
            'video/quicktime' => 'qt',
            'video/vnd.dece.hd' => 'uvh',
            'video/vnd.dece.mobile' => 'uvm',
            'video/vnd.dece.pd' => 'uvp',
            'video/vnd.dece.sd' => 'uvs',
            'video/vnd.dece.video' => 'uvv',
            'video/vnd.dvb.file' => 'dvb',
            'video/vnd.fvt' => 'fvt',
            'video/vnd.mpegurl' => 'mxu',
            'video/vnd.ms-playready.media.pyv' => 'pyv',
            'video/vnd.uvvu.mp4' => 'uvu',
            'video/vnd.vivo' => 'viv',
            'video/webm' => 'webm',
            'video/x-f4v' => 'f4v',
            'video/x-fli' => 'fli',
            'video/x-flv' => 'flv',
            'video/x-m4v' => 'm4v',
            'video/x-ms-asf' => 'asf',
            'video/x-ms-wm' => 'wm',
            'video/x-ms-wmv' => 'wmv',
            'video/x-ms-wmx' => 'wmx',
            'video/x-ms-wvx' => 'wvx',
            'video/x-msvideo' => 'avi',
            'video/x-sgi-movie' => 'movie'
        ),
        self::PDF => array(
            'application/pdf' => 'pdf'
        )
    );

    public function isImage($mime, $filename)
    {
        return self::IMAGE === $this->findType($mime, $filename);
    }

    public function isPdf($mime, $filename)
    {
        return self::PDF === $this->findType($mime, $filename);
    }

    public function isVideo($mime, $filename)
    {
        return self::VIDEO === $this->findType($mime, $filename);
    }

    public function findType($mime, $name)
    {
        $result = $this->findTypeByMime($mime);

        if (self::UNKNOW === $result) {
            $result = $this->findTypeByName($name);
        }

        return $result;
    }

    private function findTypeByMime($mime)
    {
        foreach ($this->mimes as $type => $mimes) {
            if (isset($mimes[$mime])) {
                return $type;
            }
        }

        return self::UNKNOW;
    }

    public function findTypeByName($name)
    {
        foreach ($this->mimes as $type => $mimes) {
            if ($this->extensionExists($name, $mimes)) {
                return $type;
            }
        }

        return self::UNKNOW;
    }

    private function extensionExists($filename, $array)
    {
        return in_array($this->fileExtension($filename), array_values($array));
    }

    private function fileExtension($filename)
    {
        return strtolower(substr(strrchr($filename, '.'), 1));
    }
}
