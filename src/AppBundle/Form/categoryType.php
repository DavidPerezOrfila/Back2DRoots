<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 15/05/17
 * Time: 17:01
 */


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class categoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('categoria', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class,
            array(
                'class' => 'AppBundle:Category',
                'choice_label' => 'nombre',
            ));
    }
}