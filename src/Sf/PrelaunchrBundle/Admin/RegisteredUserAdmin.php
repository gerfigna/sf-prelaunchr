<?php

namespace Sf\PrelaunchrBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;


class RegisteredUserAdmin extends Admin
{

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('referral_code')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('email')
            ->add('referralsCount', 'number', array('label' => "Referrals"))
            ->add('referrer', null, array('associated_property' => 'email'))    
            ->add('referral_code')
            ->add('created_at')
        ;
    }
    
    protected function configureRoutes(RouteCollection $collection){
        // OR remove all route except named ones
        $collection->clearExcept(array('list', 'show'));
    }


}