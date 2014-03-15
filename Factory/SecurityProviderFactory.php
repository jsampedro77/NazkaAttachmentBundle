<?php

namespace Nazka\AttachmentBundle\Factory;

use Doctrine\Common\Util\ClassUtils;
use Nazka\AttachmentBundle\Provider\SecurityProviderInterface;
use Nazka\AttachmentBundle\Provider\NullSecurityProvider;

/**
 * @author Javier Sampedro <jsampedro77@gmail.com>
 */
class SecurityProviderFactory
{

    private $providers = array();

    /**
     * Find a security provider for a given class name
     * 
     * @param type $className
     * @return \Nazka\AttachmentBundle\Provider\SecurityProviderInterface
     */
    public function getProviderByClass($className)
    {
        if (isset($this->providers[$className])) {
            return $this->providers[$className];
        } else {
            return new NullSecurityProvider();
        }
    }

    /**
     * Helper for getProviderByClass
     * 
     * @param type $entity
     * @return type
     */
    public function getProviderByEntity($entity)
    {
        return $this->getProviderByClass(ClassUtils::getClass($entity));
    }

    /**
     * Add a Security provider, this is done in compilation
     * 
     * @param Nazka\AttachmentBundle\Provider\SecurityProviderInterface $provider
     * @param type $className
     */
    public function addProvider(SecurityProviderInterface $provider, $className)
    {
        $this->providers[$className] = $provider;
    }

}
