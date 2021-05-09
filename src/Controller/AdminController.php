<?php

namespace App\Controller;
use App\Entity\Voiture;
use App\Entity\Agence;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="Admin")
     *@Route("/",name="")
     */
      public function index(): Response
    {
       $entityManager=$this->getDoctrine()->getManager();
        $agence =  $entityManager->getRepository(Agence::class)->findAll();
        
        $voiture =  $entityManager->getRepository(Voiture::class)->findAll();
        return $this->render('admin/index.html.twig', [
          
            
            'agences' => $agence,
            'voitures' =>$voiture,
           
        ]);
    } 
}
