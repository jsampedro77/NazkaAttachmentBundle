<?php

namespace Nazka\AttachmentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Nazka\AttachmentBundle\Form\DataTransformer\AttachableToIntTransformer;

/**
 * @author Javier Sampedro <jsampedro77@gmail.com>
 */
class AttachmentCollectionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $attachableTransformer = new AttachableToIntTransformer($options['em']);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($options) {
            $owner = $event->getData()['attachable'];
            $form = $event->getForm();

            $form->add('attachments', 'collection', array(
                'type' => 'nazka_attachment_admin',
                'allow_add' => true,
                'options' => array('owner' => $owner, 'accessHelp' => $options['accessHelp'])
            ));
        });

        $builder
                ->add($builder->create('attachable', 'hidden')->addModelTransformer($attachableTransformer))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
                array(
                    'accessHelp' => null
        ));


        $resolver->setRequired(array('em'));
    }

    public function getName()
    {
        return 'nazka_attachment_collection';
    }
}
