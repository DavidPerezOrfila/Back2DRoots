<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 28/02/17
 * Time: 20:16
 */

namespace AppBundle\Form;


use AppBundle\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class postType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('mensaje')
            ->add('categoria')
            ->add('imageFile', VichImageType::class, [
                'label' => 'Imagen:',
                'required' => false,
                'data_class' => null,
                'attr' => array(
                    'class' => 'form-image form-control btn-basic'
                ),
                'allow_delete' => true, // optional, default is true
                'download_link' => false, // optional, default is true
            ])
            ->add('adjuntoFile', VichFileType::class, [
                'label' => 'Adjunto:',
                'required' => false,
                'data_class' => null,
                'attr' => array(
                    'class' => 'form-file form-control btn-basic'
                ),
                'allow_delete' => true, // optional, default is true
                'download_link' => false, // optional, default is true
            ]);
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class
        ]);
    }

    public function getName()
    {
        return 'app_bundle_post_type';
    }
}