<?php
// src/AppBundle/Admin/PostAdmin.php

namespace BlogBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class ClassementAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('team')
            ->add('pilot')
            ->add('points')
            ->add('rank')
            ->add('time', 'time', array(
                   'with_seconds' => 'true',
                   'placeholder' => array(
                        'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second',
                    )
            ))
       ;
    }

    

    public function prePersist($classement)
    {
        $nam = "Classement".'_';
        if ($classement->getTeam())
            $nam = $nam.'_'.$classement->getTeam();
        else if ($classement->getPilot())
            $nam = $nam.'_'.$classement->getPilot();
        $classement->setName($nam);
    }

    public function preUpdate($classement)
    { 
        $nam = "Classement".'_';
        if ($classement->getTeam())
            $nam = $nam.'_'.$classement->getTeam();
        else if ($classement->getPilot())
            $nam = $nam.'_'.$classement->getPilot();
        $classement->setName($nam);
    }
    

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
       $datagridMapper
            ->add('name')
            ->add('team')
            ->add('pilot')
       ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('team')
            ->add('pilot')
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