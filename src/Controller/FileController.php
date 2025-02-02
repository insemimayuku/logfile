<?php

namespace App\Controller;

use App\Entity\File;
use App\Form\FileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FileController extends AbstractController
{
    #[Route('/', name: 'app_file')]
    public function index(): Response
    {
        return $this->render('file/index.html.twig', [
            'controller_name' => 'FileController',
        ]);
    }

    #[Route('/form', name:'formulaire', methods:['GET','POST'])]
    public function new(Request $req, EntityManagerInterface $mg, Security $security):Response{
        $file = new File();
        $form = $this->createForm(FileType::class, $file);
        $user=$security->getUser();

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid() ) {
            $filer = $form->get('file')->getData();

            // dd($filer->guessExtension());

            if ($file && $user) {
                $file->setThumdnail($filer->getClientOriginalName());
                $file->setPath('/files/' . $filer->getClientOriginalName());
                $file->setSize(round($filer->getSize() / 1024, 2));
                $file->setExtension($filer->guessExtension());
                $file->setIdUser($user);
                

                $filer->move($this->getParameter('kernel.project_dir') . '/public/files', $filer->getClientOriginalName());

                $mg->persist($file);
                $mg->flush();
            }       
             else{
            return $this->redirectToRoute('app_login');
        }
            # code...
        }


        return $this->render('file/new.html.twig',[
            'formulaire' => $form
        ]);
    }
}
