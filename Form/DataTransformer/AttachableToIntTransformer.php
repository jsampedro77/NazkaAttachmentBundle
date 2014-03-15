<?php

namespace Nazka\AttachmentBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Nazka\AttachmentBundle\Entity\Attachable;

/**
 * Description of AttachmentToIntTransformer
 *
 * @author javier
 */
class AttachableToIntTransformer implements DataTransformerInterface
{

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * @param mixed $entity
     *
     * @throws \Symfony\Component\Form\Exception\TransformationFailedException
     *
     * @return integer
     */
    public function transform($entity)
    {
        if ($entity instanceof Attachable) {
            return $entity->getId();
        }else{
            return $entity;
        }       
    }

    /**
     * @param mixed $id
     *
     * @throws \Symfony\Component\Form\Exception\TransformationFailedException
     *
     * @return mixed|object
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            throw new TransformationFailedException('No id submitted');
        }

        $entity = $this->om->getRepository('Nazka\AttachmentBundle\Entity\Attachable')->find($id);

        if (null === $entity) {
            throw new TransformationFailedException(sprintf(
                    'Attachable with id "%s" does not exist!', $id
            ));
        }

        return $entity;
    }
}
