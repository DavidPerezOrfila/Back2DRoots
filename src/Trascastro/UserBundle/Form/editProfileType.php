<?php

namespace Trascastro\UserBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class editProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder
                ->add('bio')
                ->add('image')
                ->add('imageFile', VichImageType::class, [
                    'required' => false,
                    'allow_delete' => true, // optional, default is true
                    'download_link' => false, // optional, default is true
                ])
            ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }


    public function getBlockPrefix()
    {
        return 'user_bundleedit_profile_type';
    }
}
