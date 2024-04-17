<?php
namespace App\Controller;

use App\Entity\Enfant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnfantController extends AbstractController
{ 
    #[Route('/enfant/create', name: 'app_enfant_create')]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $enfant = new Enfant();
        $form = $this->createFormBuilder($enfant)
            ->add('idE')
            ->add('Nom')
            ->add('Prenom')
            ->add('Age')
            ->add('Adresse')
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($enfant);
            $manager->flush();

            return $this->redirectToRoute('app_formType_success');
        }

        return $this->render('enfant/enfantindex.html.twig', [
            'formEnfant' => $form->createView()
        ]);
    }

    #[Route('/formType/success', name: 'app_formType_success')]
    public function success(): Response
    
    {
        return $this->render('/famille/famille.index.html.twig',
    [
        'controller_name' => 'FamilleController',
    ]);
    }
}