<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 28/02/17
 * Time: 20:16
 */

namespace AppBundle\Form;



use AppBundle\Entity\Comentarios;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ComentariosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('texto')
            ->add('submit', SubmitType::class, [
                'label' => $options['submit_label'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comentarios::class,
            'submit_label'=> 'Nuevo Comentario',
        ]);
    }

    public function getName()
    {
        return 'app_bundle_comentarios_type';
    }
}