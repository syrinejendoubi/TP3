<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Agence;
class AgenceController extends AbstractController
{
    /**
     * @Route("/agence/ajouter", name="AjouterAgence")
     
     */
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $agence = $entityManager->getRepository(Agence::class)->findAll();      
        return $this->render('agence/ajouter.html.twig', [
            'agences' => $agence,
        ]);
    }
    /**
          * @Route("/agence/consulter/{id}", name="consulterAgence")
     */
    public function consulter(int $id)
    
    { $agence = $this->getDoctrine()->getRepository(Agence::class)->findBy(array('id'=>$id));
        return $this->render('agence/consulter.html.twig', [
            'agences' => $agence,
    ]);
     }
     /**
          * @Route("/agence/modifier/{id}", name="modifierAgence")
     */
    public function modifier(int $id)

    {  $entityManager = $this->getDoctrine()->getManager();
        $agence = $this->getDoctrine()->getRepository(Agence::class)->findBy(array('id'=>$id));
        if(! $agence){
            throw $this->createNotFoundExpectation(
                'pas d agence avec cet id|'.$id
            );
        }
        $agence[0]->setNom('Amine');
        $entityManager->flush();
        return $this->redirectToRoute('consulterAgence',['id'=>$id]);
    }
      /**
          * @Route("/agence/supprimer/{id}", name="supprimerAgence")
     */
    public function supprimer(int $id):Response
    {  $entityManager = $this->getDoctrine()->getManager();
        $agence = $this->getDoctrine()->getRepository(Agence::class)->findBy(array('id'=>$id));
        if(! $agence){
            throw $this->createNotFoundExpectation(
                'pas de voiture avec cet id|'.$id
            );
        }
        $entityManager->remove($agence[0]);
        $entityManager->flush();
        return $this->redirectToRoute('AjouterAgence');
     } 
        /**
     * @Route("/createAgence", name="createAgence")
     */
    public function createAgence():Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $agence = new Agence();
    
        $agence->setNom('Laly');
        $agence->setTelAgence(71485217);
        $agence-> setAdresseville('Tunis');
       
        
        $entityManager->persist($agence);
        $entityManager->flush();
        return new Response ('nouvelle agence ajouté avec le nom :'.$agence->getNom());

    }


}
