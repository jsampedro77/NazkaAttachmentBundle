<?php

namespace Nazka\AttachmentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Nazka\AttachmentBundle\Factory\SecurityProviderFactory;

/**
 * @author Javier Sampedro <jsampedro77@gmail.com>
 */
class AttachmentAdminType extends AbstractType
{
    protected $securityProviderFactory;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', 'file', array('label' => 'file', 'translation_domain' => 'attachment'))
                ->add('originalFileName', null, array('label' => 'file.name', 'translation_domain' => 'attachment'))
                ->add('description', null, array('label' => 'description', 'translation_domain' => 'attachment'))
                ->add('createdByLabel', 'genemu_plain', array('label' => 'created.by', 'translation_domain' => 'attachment'))
                ->add('createdAt', 'genemu_plain', array(
                    'label' => 'created.at',
                    'translation_domain' => 'attachment',
                    'data_class' => 'DateTime'
                ))
                ->add('access', 'choice', array(
                    'label' => 'access',
                    'choices' => $this->securityProviderFactory->getProviderByEntity($options['owner'])->getAccessModes(),
                    'translation_domain' => 'attachment',
                    'help_block' => $options['accessHelp']
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
                array(
                    'data_class' => 'Nazka\AttachmentBundle\Entity\Attachment',
                    'accessHelp' => null
        ));

        $resolver->setRequired(array('owner'));
    }
    
    public function setSecurityProviderFactory(SecurityProviderFactory $securityProviderFactory){
        $this->securityProviderFactory = $securityProviderFactory;
    }

    public function getName()
    {
        return 'nazka_attachment_admin';
    }
}
