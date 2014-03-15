<?php

namespace Nazka\AttachmentBundle\Generator;

use Symfony\Component\HttpFoundation\File\File;

/**
 * Description of ThumbnailGeneratorInterface
 *
 * @author javier
 */
interface ThumbnailGeneratorInterface
{

    public function thumbnail(File $file);
}
