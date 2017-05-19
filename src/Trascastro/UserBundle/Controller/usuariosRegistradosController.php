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
            $m      = $this->getDoctrine()->getManager();
            $repo   = $m->getRepository('Trascastro\UserBundle\Entity\User');
            $users  = $repo->findAll();

            /**
             * @var $paginator \knp\Component\Pager\Paginator
             */
            $paginator  = $this->get('knp_paginator');
            $result     = $paginator->paginate(
                $users,
                $request->query->getInt('page', 1),
                4
            );

            return $this->render('UserBundle:registeredUsers:usuariosRegistrados.html.twig',
                [
                    'users' => $result,
                ]
            );

    }


}


