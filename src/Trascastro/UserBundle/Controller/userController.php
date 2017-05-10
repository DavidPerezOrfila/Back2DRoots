<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 10/05/17
 * Time: 23:52
 */

namespace Trascastro\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Trascastro\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
class UserController extends Controller
{
    public function usersAction(Request $request)
    {
        $m= $this->getDoctrine()->getManager();
        $dql= "SELECT u FROM Trascastro:User u";
        $query= $m ->createQuery($dql);

        $paginator= $this->get('knp_paginator');
        $pagination= $paginator->paginate(
                                    $query, $request->query->getInt('page', 1), 5
                                );
        return $this->render('AppBundle:Users:users.html.twig', array(
            pagination => $pagination

        ));
    }
}