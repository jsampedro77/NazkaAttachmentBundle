<?php

namespace Nazka\AttachmentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Nazka\AttachmentBundle\DependencyInjection\Compiler\AttachmentCompilerPass;

class NazkaAttachmentBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AttachmentCompilerPass());
    }
}
