<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 11/05/17
 * Time: 19:35
 */
namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class gameController extends Controller
{
    /**
     * @Route("/Games", name="app_games_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {

        return $this->render(':Games:index.html.twig');
    }
}