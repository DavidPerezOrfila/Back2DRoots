<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 30/03/17
 * Time: 16:05
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Comentarios;
use AppBundle\Form\ComentariosType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ComentariosController extends Controller
{



    /**
     * @Route("/insertCom", name="app_comentarios_insert")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function insertAction()
    {
        $comentario = new Comentarios();
        $form = $this->createForm(ComentariosType::class, $comentario);
        return $this->render(':Comentarios:Comentarios.html.twig',
            [
                'form' => $form->createView(),
                'action' => $this->generateUrl('app_Comentarios_doInsert')
            ]

        );
    }

    /**
     * @Route("/doInsertCom", name="app_Comentarios_doInsert")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function doInsert(Request $request)
    {
        if ($this->isGranted('ROLE_USER')) {
            $p = new Comentarios();
            $form = $this->createForm(ComentariosType::class, $p);
            $form->handleRequest($request);

            $user = $this->getUser();
            $p->setAuthor($user);
            $m = $this->getDoctrine()->getManager();

            $m->persist($p);
            $m->flush();
            $this->addFlash('messages', 'Comentario añadido');
            return $this->redirectToRoute('app_post_index');


        }

    }
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