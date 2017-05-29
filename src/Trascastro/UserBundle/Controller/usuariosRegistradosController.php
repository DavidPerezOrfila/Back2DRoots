<?php

namespace Trascastro\UserBundle\Controller;


use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\UserBundle\Controller\ProfileController as BaseController;
class usuariosRegistradosController extends BaseController
{

        /**
         * @Route("/", name="app_usuariosRegistrados_index")
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function registradosAction(Request $request)
    {
        if ($this->isGranted('ROLE_USER')) {
            $m = $this->getDoctrine()->getManager();
            $repo = $m->getRepository('Trascastro\UserBundle\Entity\User');
            $users = $repo->findBy(array(), array('id' => 'ASC'));
            /**
             * @var $paginator \knp\Component\Pager\Paginator
             */
            $paginator = $this->get('knp_paginator');
            $result = $paginator->paginate(
                $users,
                $request->query->getInt('page', 1),
                4
            );

            return $this->render('UserBundle:registeredUsers:usuariosRegistrados.html.twig',
                [
                    'users' => $result,
                ]
            );
        }else{
            return $this->redirectToRoute('fos_user_registration_register');
        }

    }

    /**
     * @Route("/search", name="app_usuariosRegistrados_search")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userSearchAction(Request $request)
    {
        if ($this->isGranted('ROLE_USER')) {
            $m = $this->getDoctrine()->getManager();
            $search = $_POST['search'];
            if($search == null) {
                return $this->redirect($this->generateUrl('app_post_index'));
            }
            $repo = $m->getRepository('Trascastro\UserBundle\Entity\User');

            /**
             * Utilizo la función search creada en el repositorio UserRepository
             *
             * */
            $users= $repo->search($search);

            /**
             * @var $paginator \knp\Component\Pager\Paginator
             */
            $paginator = $this->get('knp_paginator');
            $result = $paginator->paginate(
                $users,
                $request->query->getInt('page', 1),
                4
            );

            return $this->render('UserBundle:registeredUsers:usuariosRegistrados.html.twig',
                [
                    'users' => $result,
                ]
            );
        }else{
            return $this->redirectToRoute('fos_user_registration_register');
        }

    }



}


