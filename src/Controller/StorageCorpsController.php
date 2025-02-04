<?php

namespace App\Controller;

use App\Entity\StorageCorps;
use App\Form\StorageCorpsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function new():Response{
        $form = $this->createForm(StorageCorpsType::class, (new StorageCorps()));

        return $this->render('storage_corps/new.html.twig',[
            'formulaire' => $form,
        ]);
    }
}
