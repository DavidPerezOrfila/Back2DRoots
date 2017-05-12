<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 28/02/17
 * Time: 20:16
 */

namespace AppBundle\Form;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;



class editProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Bio')
            ->add('Image');
    }

    public function getParent()
    {
        return 'fos_user_profile';

    }

    public function getBlockPrefix()
    {
        return 'user';
    }
}
