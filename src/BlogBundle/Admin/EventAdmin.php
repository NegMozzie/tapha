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

class EventAdmin extends Admin
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
            ->add('startsAt', 'sonata_type_datetime_picker')
            ->add('endsAt', 'sonata_type_datetime_picker')
            ->add('parent')
       ;
    }

    public function prePersist($event)
    {
        $event->setTeams($event->getParent()->getTeam());
        $event->setCategory($event->getParent()->getCategory());
        $event->setSeason($event->getParent()->getSeason());
    }

    public function preUpdate($event)
    {
        $event->setTeams($event->getParent()->getTeam());
        $event->setCategory($event->getParent()->getCategory());
        $event->setSeason($event->getParent()->getSeason());
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