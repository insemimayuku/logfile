<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\User;
use App\Form\FileType;
use App\Repository\FileRepository;
use App\Repository\StorageCorpsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FileController extends AbstractController
{
    #[Route('/', name: 'admin_all_files')]
    public function index(FileRepository $fileR, Security $security): Response
    {   

        

        return $this->render('file/index.html.twig', [
            'controller_name' => 'FileController',
        ]);
    }

    #[Route('/form', name:'formulaire', methods:['GET','POST'])]
    public function new(Request $req, EntityManagerInterface $mg, Security $security,FileRepository $fileR):Response{
        $file = new File();
        $form = $this->createForm(FileType::class, $file);
        $user=$security->getUser();

        $store = $security->getUser()->getStorage()->getPath();
        

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid() ) {
            $filer = $form->get('file')->getData();

            // dd($filer->guessExtension());

            if ($file && $user) {
                $file->setThumdnail($filer->getClientOriginalName());
                $file->setPath('/STORE/'. $store.'/' . $filer->getClientOriginalName());
                $file->setSize(round($filer->getSize() / 1024, 2));
                $file->setExtension($filer->guessExtension());
                $file->setIdUser($user);
                

                $filer->move($this->getParameter('kernel.project_dir') . '/STORE/'.$store, $filer->getClientOriginalName());

                $mg->persist($file);

                $mg->flush();

                $fileR->updateStorageSizeUse($user->getId());
                
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
    
    #[Route(path: '/archive/{id}', name: 'fileArchive', methods: ['GET','POST'])]
    public function archive(int $id, FileRepository $fileR, EntityManagerInterface $mg, Security $security):Response{
        $file = $fileR->find($id);
        
        if ($security->getUser() && !empty($id) && $id>=0 && $file) {
            $file->setArchiver(true);

            $mg->flush();

            $fileR->updateStorageSizeUse($security->getUser()->getId());
        }


        return $this->redirectToRoute('app_dashboard');
    }

    #[Route(path: '/dowload/{id}', name: 'dowloader')]
    public function dowloaderFile(int $id,Security $security, FileRepository $fileR):Response{
        $file =$fileR->findOneBy(['id'=>$id]);

        $filePath  = $this->getParameter('kernel.project_dir').$file->getPath();
   return $this->file($filePath);
}
}
