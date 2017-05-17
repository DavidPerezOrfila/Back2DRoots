<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 17/05/17
 * Time: 16:48
 */

namespace AppBundle\Controller;


use Trascastro\UserBundle\Entity\User;
use AppBundle\Form\postType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class listUsersController
{

    /**
     * @Route("/users", name="app_listUsers_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
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

        return $this->render(':Post:index.html.twig',
            [
                'posts' => $result,
            ]
        );

    }
}