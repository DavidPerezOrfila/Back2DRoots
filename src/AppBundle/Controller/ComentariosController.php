<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 30/03/17
 * Time: 16:05
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ComentariosController extends Controller
{
    /**
     * @Route("/Comentarios", name="app_comentarios_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repo = $m->getRepository('AppBundle:Comentarios');

        $comentarios = $repo->findAll();

        return $this->render(':Comentarios:index.html.twig',
            [
                'comentarios' => $comentarios,
            ]
        );
    }
}