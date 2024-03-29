<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 28/02/17
 * Time: 20:47
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Post;
use AppBundle\Form\postType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class postController extends Controller
{

    /**
     * @Route("/", name="app_post_index")
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function indexAction(Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        $repo = $m->getRepository('AppBundle:Post');
        $posts = $repo->findBy(array(), array('id' => 'DESC'));

        /**
         * @var $paginator \knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $posts,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render(':Post:index.html.twig',
            [
                'posts' => $result,
            ]
        );

    }

    /**
     * @Route("/insert", name="app_post_insert")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function insertAction()
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        return $this->render(':Post:form.html.twig',
            [
                'form' => $form->createView(),
                'action' => $this->generateUrl('app_post_doInsert')
            ]

        );
    }

    /**
     * @Route("/doInsert", name="app_post_doInsert")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function doInsert(Request $request)
    {
        if ($this->isGranted('ROLE_USER')) {
            $p = new Post();
            $form = $this->createForm(postType::class, $p);
            $form->handleRequest($request);
            if ($form->isValid()) {
                $user = $this->getUser();
                $p->setAuthor($user);
                $m = $this->getDoctrine()->getManager();

                $m->persist($p);
                $m->flush();
                $this->addFlash('messages', 'Post añadido');
                return $this->redirectToRoute('app_post_index');
            }
            $this->addFlash('messages', 'Revisa los datos introducidos');
            return $this->render(':Post:form.html.twig',
                [
                    'form' => $form->createView(),
                    'action' => $this->generateUrl('app_post_doInsert')
                ]

            );
        }
    }


    /**
     * @Route(path="/updatePost/{id}", name="app_post_update")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction($id)
    {
        if ($this->isGranted('ROLE_USER')) {
            $m = $this->getDoctrine()->getManager();
            $repository = $m->getRepository('AppBundle:Post');
            ;
            $post = $repository->find($id);
            $usuarioActual= $this->getUser()->getId();
            $author= $post->getAuthor()->getId();
            if ($usuarioActual !== $author) {
                return $this->redirectToRoute('app_post_index');
            }
            $form = $this->createForm(postType::class, $post);

            return $this->render(':Post:form.html.twig', [
                'form' => $form->createView(),
                'action' => $this->generateUrl('app_post_doUpdate', ['id' => $id])
            ]);
        }
    }

    /**
     * @Route(path="/doUpdate/{id}", name="app_post_doUpdate")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function doUpdateAction($id, Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Post');

        $post = $repository->find($id);
        $form = $this->createForm(postType::class, $post);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $m->flush();
            $this->addFlash('messages', 'Post Actualizado');
            return $this->redirectToRoute('app_post_index');
        }
        $this->addFlash('messages', 'Revisa tu formulario');
        return $this->render(':Post:form.html.twig',
            [
                'form' => $form->createView(),
                'action' => $this->generateUrl('app_post_doUpdate', ['id' => $id]),
            ]
        );
    }

    /**
     * @Route(
     *     path="/remove/{id}",
     *     name="app_post_remove"
     * )
     * @ParamConverter(name="post", class="AppBundle:Post")
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction(Post $post)
    {
        $m = $this->getDoctrine()->getManager();
        $m->remove($post);
        $m->flush();
        $this->addFlash('messages', 'Post borrado');
        return $this->redirectToRoute('app_post_index');
    }


    /**
     * @Route("/postSearch", name="app_post_search")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postSearchAction(Request $request)
    {
        if ($this->isGranted('ROLE_USER')) {
            $m = $this->getDoctrine()->getManager();
            $search = $_POST['search'];
            if($search == null) {
                $this
                    ->addFlash('messages', 'Tu búsqueda no ha encontrado ningún resultado!');

                return $this->redirectToRoute('app_post_index');
            }
            $repo = $m->getRepository('AppBundle:Post');

            /**
             * Utilizo la función search creada en el repositorio PostRepository
             *
             * */
            $posts= $repo->postSearch($search);

            /**
             * @var $paginator \knp\Component\Pager\Paginator
             */
            $paginator = $this->get('knp_paginator');
            $result = $paginator->paginate(
                $posts,
                $request->query->getInt('page', 1),
                4
            );

            return $this->render(':Post:index.html.twig',
                [
                    'posts' => $result,
                ]
            );
        }else{
            return $this->redirectToRoute('fos_user_registration_register');
        }



    }
}
