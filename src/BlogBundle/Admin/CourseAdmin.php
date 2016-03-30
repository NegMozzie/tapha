<?php
// src/AppBundle/Admin/PostAdmin.php

namespace BlogBundle\Admin;

use BlogBundle\Handler\BlogUserHandler;
use Doctrine\ORM\EntityRepository;
use BlogBundle\Entity\Post;
use BlogBundle\Admin\TermAdmin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class CourseAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        //$object = $formMapper->getData();
        $formMapper
            ->add('name')
            ->add('excerptPhoto', 'sonata_type_model', array(
                'class' => 'Application\Sonata\MediaBundle\Entity\Media',
                'property' => 'name'
            ))
            ->add('startsAt')
            ->add('endsAt')
            ->add('parent')
            ->add('classement', 'sonata_type_model', array(
                'multiple' => true,
                'required' => false
                ))
       ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
       $datagridMapper
            ->add('name')
            ->add('startsAt')
            ->add('endsAt')
       ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
       ;
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
           ->add('name')
       ;
    }
}