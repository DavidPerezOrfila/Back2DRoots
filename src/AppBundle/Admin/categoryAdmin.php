<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 12/05/17
 * Time: 20:11
 */
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class categoryAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('nombre', 'text');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('nombre');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('nombre');
    }
}