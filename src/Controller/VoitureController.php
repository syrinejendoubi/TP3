<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Voiture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;

class VoitureController extends AbstractController
{   
     /**
     * @Route("/voiture/ajouter", name="AjouterVoiture")
     */
    public function index(): Response
    {  $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findAll();

        return $this->render('voiture/ajouter.html.twig', [
            'voitures' => $voitures,
        ]);
    }
    /**
     * @Route("/voiture/{mat}", name="afficheByMatricule")
     */
    public function afficher(String $mat): Response
    {  $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findBy(array('matricule'=>$mat));
        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitures,
        ]);
    } 
     /**
     * @Route("/voiture/modifier/{mat}", name="modifierVoiture")
     */
    public function modifier(String $mat):Response
    {  $entityManager = $this->getDoctrine()->getManager();
        $voiture = $this->getDoctrine()->getRepository(Voiture::class)->findBy(array('matricule'=>$mat));
        if(! $voiture){
            throw $this->createNotFoundExpectation(
                'pas de voiture avec la marticule|'.$mat
            );
        }
        $voiture[0]->setMarque('Mercedes');
        $entityManager->flush();
        return $this->redirectToRoute('afficheByMatricule',['mat'=>$mat]);
    }
     /**
     * @Route("/supprimervoiture/{mat}", name="supprimerVoiturebymat")
     */
    public function Supprimer(String $mat):Response
    {  $entityManager = $this->getDoctrine()->getManager();
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
     * @Route("/createVoiture", name="createVoiture")
     */
    public function createVoiture():Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $voiture = new Voiture();
        $voiture->setMatricule('TT258N147');
        $voiture->setMarque('RANGE');
        $voiture->setCouleur('Bleu');
        $voiture->setCarburant('Shell');
        $voiture->setDescription('Confort');
        $voiture->setNbrplace(5);
        $voiture->setDatemiseencirculation('16/11/2020');
        $voiture->setDisponibilite(true);
        $entityManager->persist($voiture);
        $entityManager->flush();
        return new Response ('nouvelle voiture ajouté avec la matricule num'.$voiture->getMatricule());

    }
   
}
    

