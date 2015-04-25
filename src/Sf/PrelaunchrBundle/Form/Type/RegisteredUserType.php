<?php

namespace Sf\PrelaunchrBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisteredUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email', array(
                    'attr' => array(
                        'placeholder'   => 'Enter Email',
                        'class'         => 'email brandon'
                    ),
                    'required'    => true,
                    'label'       => false  
                ))
                ->add('commit', 'submit', array(
                    'attr'  => array(
                        'class'     => "submit brandon",
                    ),
                    'label'  => 'Step Inside'
                ));
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sf\PrelaunchrBundle\Entity\RegisteredUser',
        ));
    }

    public function getName()
    {
        return 'registered_user';
    }
}