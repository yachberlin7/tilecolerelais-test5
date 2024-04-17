<?php

namespace App\Controller;

use App\Entity\Famille;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FamilleController extends AbstractController


{
    #[Route('/famille/create', name:'app_famille_create')]
    public function create(Request $request, EntityManagerInterface $manager):Response
{
    $famille = new Famille();
    $form = $this->createFormBuilder($famille)
        ->add('idF')
        ->add('Nompere')
        ->add('Prenompere')
        ->add('Nommere')
        ->add('Prenommere')
        ->add('Fratrie')
        ->add('save', SubmitType::class,['label'=>'Enregistrer'])
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $manager->persist($famille);
            $manager->flush();

            return $this->redirectToRoute('app_FormType_success');
        }
        return $this->render('famille/famille.index.html.twig',[
            'formFamille'=> $form->createView()
        ]);
        
    }

    #[Route('/formType/success',name:'app_formType_success')]
    public function success(): Response
    {
        return $this->render('formType/success.html.twig');
    }

    #[Route('/famille', name: 'app_famille')]
    public function index(): Response
    {
        return $this->render('famille/famille.index.html.twig', [
            'controller_name' => 'FamilleController',
        ]);
    }
}
