<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', array());
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        return $this->render('admin/index.html.twig', array(
            'page_name' => 'Admin page',
        ));
    }
}