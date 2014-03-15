<?php

namespace Nazka\AttachmentBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
/**
 * Description of AttachmentCompilerPass
 *
 * @author javier
 */
class AttachmentCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $factoryServiceName = 'nazka_attachment.security.factory';
        if (false === $container->hasDefinition($factoryServiceName)) {
            return;
        }

        $definition = $container->getDefinition($factoryServiceName);

        foreach ($container->findTaggedServiceIds('nazka.attachment.security.provider') as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $definition->addMethodCall('addProvider', array(new Reference($id), $attributes["class"]));
            }
        }
    }
}
