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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ComentariosController extends Controller
{



    /**
     * @Route("/CommentIndex/{id}", name="app_comentarios_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repo = $m->getRepository('AppBundle:Comentarios');
        $repo2 = $m->getRepository('AppBundle:Post');
        $post = $repo2->findOneById($id);
        $postID = $post->getId();
        $comentario = $repo->findByPost($postID);
        return $this->render(':Comentarios:Comentarios.html.twig',
            [
                'comentario' => $comentario,
            ]
        );
    }
    /**
     * @Route("/NewComment/{id}", name="app_comentarios_new")
     *@return \Symfony\Component\HttpFoundation\Response
     *  @Security("has_role('ROLE_USER')")
     */
    public function createAction($id)
    {
        $comentario = new Comentarios();
        $form = $this->createForm(ComentariosType::class, $comentario);
        return $this->render(':Comentarios:form.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_comentarios_doCreate', ['id' => $id])
            ]
        );
    }
    /**
     * @Route("/CommentDoCreate/{id}", name="app_comentarios_doCreate")
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function doCreateAction(Request $request, $id)
    {
        if ($this->isGranted('ROLE_USER')) {
            $comment = new Comentarios();
            $form = $this->createForm(ComentariosType::class, $comment,
                ['action' => $this->generateUrl('app_comentarios_doCreate', ['id'=>$id])]);
            $form->handleRequest($request);
            if ($form->isValid()) {
                $user = $this->getUser();
                $comment->setAuthor($user);
                $m = $this->getDoctrine()->getManager();
                $repository = $m->getRepository('AppBundle:Post');
                $post = $repository->find($id);
                $comment->setPost($post->getId());
                $m = $this->getDoctrine()->getManager();
                $m->persist($comment);
                $m->flush();
                $this->addFlash('messages', 'Comentario creado');
                return $this->redirectToRoute('app_post_index', ['id' => $id]);
            }
            $this->addFlash('messages', 'Review your form data');
            return $this->render(':Comentarios:form.html.twig',
                [
                    'form' => $form->createView(),
                    'action' => $this->generateUrl('app_comentarios_doCreate', ['id' => $id])
                ]
            );
        }
    }
    /**
     * @Route("/updateComment/{id}", name="app_comentarios_update")
     *@return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function updateAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Comentarios');
        $comment = $repository->find($id);
        $user = $this->getUser();
        $userComment= $comment->getAuthor();
        if ($user->getId() === $userComment->getId() or ($user->getUsername() === "admin")) {
            $form = $this->createForm(ComentariosType::class, $comment);
            return $this->render(':Comentarios:form.html.twig',
                [
                    'form' => $form->createView(),
                    'action' => $this->generateUrl('app_comentarios_doUpdate', ['id' => $id])
                ]
            );
        }
        return $this->redirectToRoute('app_post_index');
    }
    /**
     * @Route("/CommentDoUpdate/{id}", name="app_comentarios_doUpdate")
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function doUpdateAction($id, Request $request)
    {
        $m          = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Comentario');
        $comment = $repository->find($id);
        $user = $this->getUser();
        $userComment= $comment->getAuthor();
        if ($user->getId() === $userComment->getId() or ($user->getUsername() === "admin")) {
            $form       = $this->createForm(ComentariosType::class, $comment);
            $form->handleRequest($request);
            if ($form->isValid()) {
                $m->flush();
                $this->addFlash('messages', 'comentario actualizado');
                return $this->redirectToRoute('app_comentarios_index', ['id' => $comment->getTexto()->getId()]);
            }
            $this->addFlash('messages', 'Review your form');
            return $this->render(':Comentarios:form.html.twig',
                [
                    'form'      => $form->createView(),
                    'action'    => $this->generateUrl('app_comentarios_doUpdate', ['id' => $id]),
                ]
            );
        }
        return $this->redirectToRoute('app_post_index');
    }
    /**
     * @Route("/removeComment/{id}", name="app_comentarios_remove")
     *@return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function removeCommentAction(Comentarios $comment)
    {
        $Post = $comment->getTexto();
        if ($this->getUser() == $comment->getAuthor()) {
            $m = $this->getDoctrine()->getManager();
            $m->remove($comment);
            $m->flush();
            return $this->redirectToRoute('app_post_index');
        } else {
            return $this->redirectToRoute('app_post_index');
        }
    }
}
