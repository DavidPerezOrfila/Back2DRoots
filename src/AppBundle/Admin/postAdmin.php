<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 15/05/17
 * Time: 15:58
 */

namespace AppBundle\Admin;
use AppBundle\Entity\Post;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;



class postAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Content', array('class' => 'col-md-9'))
            ->add('titulo', 'text', array(
                'label' => 'Titulo'
            ))
            ->add('author', 'entity', array(
                'class' => 'Trascastro\UserBundle\Entity\User'
            ))
            ->add('mensaje', 'text')

            ->end()

            ->with('Meta data', array('class' => 'col-md-3'))
                ->add('categoria', 'sonata_type_model', [
                    'class' => 'AppBundle\Entity\Category',
                    'property' => 'nombre',
                ])

            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('titulo')
            ->add('author')
            ->add('mensaje')
            ->add('categoria.nombre')
        ;
    }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('titulo')
            ->add('author')
            ->add('categoria', null, array(), 'entity', array(
                'class'    => 'AppBundle\Entity\Category',
                'choice_label' => 'nombre',
            ))
        ;
    }

    public function toString($object)
    {
        return $object instanceof Post
            ? $object->getTitulo()
            : 'Post'; // shown in the breadcrumb on the create view
    }

}