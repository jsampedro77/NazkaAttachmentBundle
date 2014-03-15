Nakza Attachment Bundle
=======================

Attach a collection of files to any Doctrine entity. Features include:

- Easy attach files to an entity using Trait.
- Configurable Security provider for each entity with attachments.
- Controller to list, view and download attachments
- Thumbnail generation for images and video (optional). Can create your own thumnail generators.
- File uploads with VichUploader and KnpGaufrette




Installation
------------

Create a composer.json in your projects root-directory:

    {
        "require": {
            "nazka/attachment-bundle": "*"
        }
    }

and run:

    curl -s http://getcomposer.org/installer | php
    php composer.phar install


Temporally, you have to configure Gaufrette and VichUploader. This we be automatically done in future.

in config.yml
``` yaml
knp_gaufrette:
    adapters:
        attachment_adapter:
            local:
                directory: %kernel.root_dir%/../private/attachments
    filesystems:
        attachment_fs:
            adapter:    attachment_adapter

vich_uploader:
    db_driver: orm
    gaufrette: true
    storage: nazka_attachment.storage.gaufrette
    mappings:
        attachment:
            upload_destination: attachment_fs
            inject_on_load: false

   
```                

This parameter must be created to have video thumnails generated by ffmpeg, set to false if you want to disable:
	
	nazka_attachment_ffmpeg_path: /usr/bin/ffmpeg

Usage
-----

Your entity should use HasAttachmentsTrait, this way it will also implemente HasAttachmentsInterface.

``` php
<?php

namespace Nazka\Sample\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nazka\AttachmentBundle\Model\HasAttachmentsInterface;
use \Nazka\AttachmentBundle\Entity\HasAttachmentsTrait;

/**
 * Nazka\SampleBundle\Entity\SupportCase
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class SupportCase implements HasAttachmentsInterface
{

    use HasAttachmentsTrait;

```

Now you can access the attachments with the methods provided in the Trait, like:

    $entity->getAttachments();



TO-DO
-----
- Finish documentation, security access provider section and thumbnail generation.
- Automatic creation of nazka_attachment_fs Gaufrette FileSystem.
