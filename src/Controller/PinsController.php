<?php

namespace App\Controller;

use App\Repository\PinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class PinsController extends AbstractController
{
    /** 
    *@Route("/")
    */
    public function index(PinRepository $repo): Response
    {
       return $this->render('pins/index.html.twig', ['pins' => $repo->findAll()]);
    }

    /** 
    *@Route("/pins/create", methods={"GET", "POST"})
    */
    public function create()
    {
        return $this->render('pins/create.html.twig');
    }
}
