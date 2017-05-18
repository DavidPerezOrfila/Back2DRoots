<?php

namespace Trascastro\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class usuariosRegistradosController extends Controller
{

        /**
         * @Route("/", name="app_usuariosRegistrados_index")
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function registradosAction(Request $request)
    {
            $m = $this->getDoctrine()->getManager();
            $repo = $m->getRepository('Trascastro\UserBundle\Entity\User');
            $users = $repo->findAll();



            /**
             * @var $paginator \knp\Component\Pager\Paginator
             */
            $paginator = $this->get('knp_paginator');
            $result = $paginator->paginate(
                $users,
                $request->query->getInt('page', 1),
                5
            );

            return $this->render('UserBundle:registeredUsers:usuariosRegistrados.html.twig',
                [
                    'users' => $result,
                ]
            );

    }
}


