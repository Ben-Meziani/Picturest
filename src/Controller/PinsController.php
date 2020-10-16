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
     * @Route("/pins/{id<[0-9]+>}", name="app_pins_show")
     */
    public function show(PinRepository $repo, int $id): Response
    {
       
        $pin = $repo->find($id);
        if(! $pin)
        {
            throw $this->createNotFoundException('Pin #' . $id . ' not found');
        }
       
        return $this->render('pins/show.html.twig', compact('pin'));
    }

    /** 
    *@Route("/create", name="app_pins_create", methods={"GET", "POST"})
    */
    public function create(Request $request, EntityManagerInterface $em): Response
    {

        $pin = new Pin;
       
        $form = $this->createFormBuilder($pin)
        ->add('titre', TextType::class,[
            'attr' => ['autofocus' => true]
            ])
        ->add('description', TextareaType::class, ['attr' =>['rows' => 10, 'cols' => 50]]) 
       
        ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            
            $em->persist($pin);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }

       return $this->render('pins/create.html.twig', [
           'monFormulaire' => $form->createView()
       ]);
    }
}
