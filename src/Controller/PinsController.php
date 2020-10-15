<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class PinsController extends AbstractController
{
    /** 
    *@Route("/", name="app_home", methods={"GET"})
    */
    public function index(PinRepository $repo): Response
    {
        return $this->render('pins/index.html.twig', ['pins'=> $repo->findAll()]);
    }

    /** 
    *@Route("/pins_create", name="app_pins_create", methods={"GET", "POST"})
    */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createFormBuilder()
        ->add('title', TextType::class)
        ->add('description', TextareaType::class) 
        ->add('submit', SubmitType::class, ['label' =>'Create Pin']) 
        ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();

            $pin = new Pin;
            $pin->setTitre($data['title']);
            $pin->setDescription($data['description']);
            $em->persist($pin);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }

       return $this->render('pins/create.html.twig', [
           'monFormulaire' => $form->createView()
       ]);
    }
}
