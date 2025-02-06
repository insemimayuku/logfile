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
        $user = $security->getUser();
        $storage = new StorageCorps();
        $storePath = bin2hex(random_bytes(3));
        $form = $this->createForm(StorageCorpsType::class, $storage);

        $form->handleRequest($req);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $storage->setSizeAllow(20.00);
            $storage->setSizeUse(00.00);
            $storage->setPath($storePath);
            $mg->persist($storage);
            $mg->flush();

            $user->setStorage($storage);
            $mg->persist($user);
            $mg->flush();

        }

        return $this->render('storage_corps/new.html.twig',[
            'user' =>($security->getUser())? $security->getUser()->getUserIdentifier(): 'no user connecte',
            'formulaire' => $form,
        ]);
    }
}
