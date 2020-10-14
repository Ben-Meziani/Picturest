<?php

namespace App\Controller;

use App\Entity\Pin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class PinsController extends AbstractController
{
    /** 
    *@Route("/")
    */
    public function index(EntityManagerInterface $em): Response
    {
        $pin = new Pin;
         $pin->setTitre('Title 1');
         $pin->setDescription('Description 1');

     
        $em->persist($pin);
        $em->flush();

        return $this->render('pins/index.html.twig');
    }
}
