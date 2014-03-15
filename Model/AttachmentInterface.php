<?php

namespace Nazka\AttachmentBundle\Model;

/**
 * Description of AttachmentInterface
 *
 * @author javier
 */
interface AttachmentInterface
{

    public function getMimeType();

    public function setMimeType($mimeType);

    public function getThumbnail();

    public function setThumbnail($thumnail);

    public function getSize();

    public function setSize($size);

    public function getOriginalFilename();

    public function setOriginalFilename($filename);
    
    public function getAttachable();
    
    public function getAccess();
}
