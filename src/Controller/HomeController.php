<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/",name="homePage")
     */
    public function homePage():Response{

        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/product/search",name="searchProduct")
     */
    public function searchProduct():Response{

        return $this->render('product/findProduct.html.twig');
    }

    /**
     * @Route("/order/search",name="searchOrder")
     */
    public function searchOrder():Response{

        return $this->render('order/findOrder.html.twig');
    }

}