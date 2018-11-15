<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProjectRepository;
;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(Request $request, ProjectRepository $projectRepository)
    {
        $form = $this->createForm(ContactType::class);
  
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView(),
            'projects' => $projectRepository->findAll(),
        ]);
    }


    /**
     * @Route("/", name="contact", methods={"POST"})
     */
    public function contact(Request $request, ProjectRepository $projectRepository)
    {

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $this->addFlash(
                'notice',
                'Votre message a bien été pris en compte.'
            );

            return $this->redirectToRoute('home');
        }

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView(),
            'projects' => $projectRepository->findAll(),
        ]);
    }
}
