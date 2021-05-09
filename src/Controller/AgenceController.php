<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Agence;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AgenceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;

class AgenceController extends AbstractController
{
    /**
     * @Route("/agence/ajouter", name="AjouterAgence")
     
     */
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $agence = $entityManager->getRepository(Agence::class)->findAll();      
        return $this->render('agence/index.html.twig', [
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
    public function modifier(int $id, Request $request): Response

    {  $repo = $this->getDoctrine()->getRepository(Agence::class);
        $agence = $repo->find($id);
        $form= $this->createForm(AgenceType::class, $agence);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($agence);
            $em->flush();
            return $this->redirectToRoute('AjouterAgence');
        }
        return $this->render('/agence/modifier.html.twig',['form'=> $form->createView()
        ]);
    }
      /**
          * @Route("/agence/supprimer/{id}", name="supprimerAgence")
     */
    public function supprimer(int $id):Response
    {  $entityManager = $this->getDoctrine()->getManager();
        $agence = $this->getDoctrine()->getRepository(Agence::class)->find($id);
        if(! $agence){
            throw $this->createNotFoundExpectation(
                'pas de voiture avec cet id|'.$id
            );
        }
        $entityManager->remove($agence);
        $entityManager->flush();
        return $this->redirectToRoute('AjouterAgence');
     } 
        /**
     * @Route("/createAgence", name="createAgence")
     */
    public function createAgence(Request $request):Response
    {
        $agence = new Agence();
        $form= $this->createForm(agenceType::class, $agence);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($agence);
            $entityManager->flush();

            return $this->redirectToRoute('AjouterAgence');
        }
        return $this->render('agence/ajouter.html.twig', [
            'form' => $form->createView()
            ]);
    }


}
