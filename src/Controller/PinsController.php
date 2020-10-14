<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class PinsController extends AbstractController
{
    /** 
    *@Route("/")
    */
   
    public function __invoke(): Response
    {
        return $this->render('pins/index.html.twig');
    }
}
