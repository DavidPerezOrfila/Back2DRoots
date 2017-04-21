<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 30/03/17
 * Time: 16:05
 */

namespace AppBundle\Controller;


use AppBundle\Form\ComentariosType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ComentariosController extends Controller
{

    /**
     *
     */
    public function mostrarComentariosAction($id)
    {
        $comentario = New Comentarios();
        $form = $this->createForm(ComentariosType::class, $comentario, ['action' => $this->generateUrl('app_comentario_new', ['id' => $id])]);
        return $this->render('Comentarios/mostrarComentarios.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}