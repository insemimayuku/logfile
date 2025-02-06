<?php

namespace App\Controller;

use App\Entity\StorageCorps;
use App\Form\StorageCorpsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StorageCorpsController extends AbstractController
{
    #[Route('/storageCorps', name: 'app_storage_corps')]
    public function index(): Response
    {
        return $this->render('storage_corps/index.html.twig', [
            'controller_name' => 'StorageCorpsController',
        ]);
    }
    #[Route('/form-storage','makeStorage',methods: ['GET','POST'])]
    public function new(Request $req, EntityManagerInterface $mg,Security $security):Response{
        $storage = new StorageCorps();
        $form = $this->createForm(StorageCorpsType::class, $storage);

        $form->handleRequest($req);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $storage->setSizeAllow(20.00);
            $storage->setSizeUse(00.00);
            $mg->persist($storage);
            $mg->flush();
        }

        return $this->render('storage_corps/new.html.twig',[
            'formulaire' => $form,
        ]);
    }
}
