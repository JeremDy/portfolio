<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProjectRepository;
use App\Repository\SkillRepository;
use App\Repository\OwnerRepository;
;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(Request $request, ProjectRepository $projectRepository, SkillRepository $skillRepository, OwnerRepository $ownerRepository)
    {
        $form = $this->createForm(ContactType::class);
  
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView(),
            'projects' => $projectRepository->findAll(),
            'skills' => $skillRepository->findAll(),
            'owner' => $ownerRepository->findLastInserted(),
        ]);
    }


    /**
     * @Route("/", name="contact", methods={"POST"})
     */
    public function contact(Request $request, ProjectRepository $projectRepository, \Swift_Mailer $mailer)
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
            
            $message = (new \Swift_Message('Email de confirmation'))
            ->setFrom(getenv('SITE_MAIL'))
            ->setTo($contact->getMail())
            ->setBody(
                $this->renderView(
                    'mail/sendemail.html.twig',
                    array('name' => $contact->getName())
                ),
                'text/html'
            );

            $messageToAdmin = (new \Swift_Message('Nouveau message sur votre portfolio'))
            ->setFrom(getenv('SITE_MAIL'))
            ->setTo(getenv('ADMIN_MAIL'))
            ->setBody(
                $this->renderView(
                    'mail/mailToAdmin.html.twig',
                    array(
                        'name' => $contact->getName(),
                        'sujet' => $contact->getSubject(),
                        'email' => $contact->getMail(),
                        'message' => $contact->getMessage(),
                        )
                ),
                'text/html'
            );
 
            $mailer->send($messageToAdmin);
            $mailer->send($message);

            return $this->redirectToRoute('home');
        }

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView(),
            'projects' => $projectRepository->findAll(),
        ]);
    }
}
