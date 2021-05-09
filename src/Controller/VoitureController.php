<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Voiture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Form\VoitureType;
use App\Entity\User;
class VoitureController extends AbstractController
{   
     /**
     * @Route("/voiture", name="AjouterVoiture")
     */
    public function index(): Response
    { $this->denyAccessUnlessGranted('ROLE_AGENT'); 
        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findAll();

        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitures,
        ]);
    }
    /**
     * @Route("/voiture/{mat}", name="afficheByMatricule")
     */
    public function afficher(String $mat): Response
    {  $this->denyAccessUnlessGranted('ROLE_AGENT');
        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findBy(array('matricule'=>$mat));
        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitures,
        ]);
    } 
     /**
     * @Route("/voiture/modifier/{id}", name="modifierVoiture")
     */
    public function modifier(int $id, Request $request): Response

       { $this->denyAccessUnlessGranted('ROLE_AGENT');
        $repo = $this->getDoctrine()->getRepository(Voiture::class);
        $voiture = $repo->find($id);
        $form= $this->createForm(voitureType::class, $voiture);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($voiture);
            $em->flush();
            return $this->redirectToRoute('AjouterVoiture');
        }
        return $this->render('voiture/modifier.html.twig', [
            'form' => $form->createView()
        ]);
        
    }
     /**
     * @Route("/supprimervoiture/{mat}", name="supprimerVoiturebymat")
     */
    public function Supprimer(String $mat):Response
    
    { $this->denyAccessUnlessGranted('ROLE_AGENT');
         $entityManager = $this->getDoctrine()->getManager();

        $voiture = $this->getDoctrine()->getRepository(Voiture::class)->findBy(array('matricule'=>$mat));
        if(! $voiture){
            throw $this->createNotFoundExpectation(
                'pas de voiture avec la marticule|'.$mat
            );
        }
        $entityManager->remove($voiture[0]);
        $entityManager->flush();
        return $this->redirectToRoute('AjouterVoiture');
    }
    /**
    * @Route("/admin", name="admin")
     */
     public function admin()
       { $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findAll();
         $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        
    
    return $this->render('admin/index.html.twig', [
        'voitures' => $voitures,
        'users' => $users 
    ]);
    }
     /**
     * @Route("/createVoiture", name="createVoiture")
     */
    public function createVoiture( Request $request ):Response
    {$this->denyAccessUnlessGranted('ROLE_AGENT');
        $voiture = new Voiture();
        $form= $this->createForm(voitureType::class, $voiture);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $voiture->setDisponibilite(1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($voiture);
            $entityManager->flush();

            return $this->redirectToRoute('AjouterVoiture');
        }
        return $this->render('voiture/ajouter.html.twig', [
            'form' => $form->createView()
        ]);
    }
   
}
    

