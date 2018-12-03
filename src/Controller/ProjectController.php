<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Project;
use App\Repository\OwnerRepository;

class ProjectController extends AbstractController
{
    /**
     * @Route("/projet/{id}", name="project")
     */
    public function index(Project $project, OwnerRepository $ownerRepository)
    {
        return $this->render('project/index.html.twig', [
            'controller_name' => 'ProjectController',
            'project' => $project,
            'owner' => $ownerRepository->findLastInserted(),
        ]);
    }
}
