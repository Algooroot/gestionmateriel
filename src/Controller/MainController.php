<?php

namespace App\Controller;

use DateTime;
use DateTimeInterface;
use App\Entity\Equipement;
use App\Form\EquipementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{


    /**
     * @Route("/", name="app_main")
     */
    public function index(): Response
    {
        $data = $this->getDoctrine()->getRepository(Equipement::class)->findAll();
        return $this->render('main/index.html.twig', [
            'listeequipement' => $data
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $equipement = new Equipement();
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipement);
            $em->flush();

            $this->addFlash('notice','Equipement Ajouter!!');
            return $this->redirectToRoute('app_main');

        }


        return $this->render('main/create.html.twig', [
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function update(Request $request, $id)
    {


        $equipement = $this->getDoctrine()->getRepository(Equipement::class)->find($id);
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipement);
            $em->flush();

            $this->addFlash('notice','Equipement Modifier!!');
            return $this->redirectToRoute('app_main');
        }

        return $this->render('main/update.html.twig', [
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Request $request, $id)
    {
        $data = $this->getDoctrine()->getRepository(Equipement::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($data);
        $em->flush();

        $this->addFlash('notice','Equipement Supprimer!!');
        return $this->redirectToRoute('app_main');
    }
}
