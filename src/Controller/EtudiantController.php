<?php

namespace App\Controller;

use App\Entity\Etudiant;

use App\Form\EtudiantType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/etudiant')]
class EtudiantController extends AbstractController
{
    private $manager;
    private $repository;
    public function __construct(private ManagerRegistry $doctrine)
    {
        $this->manager = $this->doctrine->getManager();
        $this->repository = $this->doctrine->getRepository(Etudiant::class);
    }
    #[Route('/', name: 'app_etudiant')]
    public function index(): Response
    {
        $etudiants = $this->repository->findAll();
        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiants,
        ]);
    }
    #[Route('/delete/{id}', name: 'app_etudiant_delete')]
    public function delete(Etudiant $etudiant = null): Response
    {

        if(!$etudiant) {
            throw new NotFoundHttpException("Not Found");
        } else {
            $this->manager->remove($etudiant);
            $this->manager->flush();
            $this->addFlash('success', "etudiant supprimée avec succès");
            return $this->forward('App\\Controller\\EtudiantController::index');
        }
    }
    #[Route('/edit/{id?0}', name: 'app_etudiant_edit')]
    public function edit(Request $request, Etudiant $etudiant = null): Response
    {
        if (!$etudiant) {
            $etudiant = new Etudiant();

        }

        $form = $this->createForm(EtudiantType::class, $etudiant);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $this->manager->persist($etudiant);
            $this->manager->flush();
            return $this->redirectToRoute('app_etudiant');
        }
        return $this->render('etudiant/edit.html.twig', [

            'form' => $form->createView(),
        ]);
    }
    #[Route('/ajout', name: 'app_etudiant_ajout')]
public function ajout(Request $request, Etudiant $etudiant = null): Response
{
    if (!$etudiant) {
        $etudiant = new Etudiant();

    }

    $form = $this->createForm(EtudiantType::class, $etudiant);

    $form->handleRequest($request);
    if($form->isSubmitted() ) {

        $this->manager->persist($etudiant);
        $this->manager->flush();
        $this->addFlash('succes',"etudiant ajouté avec succes");
        return $this->forward('App\\Controller\\EtudiantController::index');

    }
    return $this->render('etudiant/edit.html.twig', [

        'form' => $form->createView(),
    ]);
}
}
