<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\File;
use App\Repository\FileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(EntityManagerInterface $entityManager,FileRepository $fileR): Response
    {
        $user = $this->getUser();

        $pourcentage = (($user->getStorage()->getSizeUse()*100)/$user->getStorage()->getSizeAllow());

        // Si c'est un admin, redirection vers le dashboard admin
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_dashboard');
        }

        // Récupére les fichiers de l'utilisateur
        $files = $fileR->findBy(['id_user'=> $user, 'archiver'=>0]);

        return $this->render('dashboard/user_dashboard.html.twig', [
            'user' => $user,
            'files' => $files,
            'stokage' => $user->getStorage()->getName(),
            'percent' => $pourcentage
        ]);
    }

    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    #[IsGranted('ROLE_ADMIN')]
    public function adminDashboard(EntityManagerInterface $entityManager,FileRepository $fileR): Response
    {
        $userCount = $entityManager->getRepository(User::class)->count([]);
        $fileCount = $entityManager->getRepository(File::class)->count([]);

            

        return $this->render('dashboard/admin_dashboard.html.twig', [
            'userCount' => $userCount,
            'fileCount' => $fileCount,
        ]);
    }
}
