<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\File;
use App\Form\UserRoleType;
use App\Repository\FileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route('/dashboard', name: 'admin_dashboard')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $userCount = $entityManager->getRepository(User::class)->count([]);
        $fileCount = $entityManager->getRepository(File::class)->count([]);

        return $this->render('admin/dashboard.html.twig', [
            'userCount' => $userCount,
            'fileCount' => $fileCount,
        ]);
    }

    #[Route('/users', name: 'admin_users')]
    public function listUsers(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager->getRepository(User::class)->findAll();

        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/user/{id}/edit', name: 'admin_edit_user')]
    public function editUser(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserRoleType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('admin_users');
        }

        return $this->render('admin/edit_user.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/user/{id}/delete', name: 'admin_delete_user', methods: ['POST'])]
    public function deleteUser(User $user, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('admin_users');
    }

    #[Route('/files', name: 'admin_files')]
    public function listFiles(FileRepository $fileR, Security $security,EntityManagerInterface $entityManager): Response
    {
        $files =$fileR->findAll() ;

        return $this->render('admin/files.html.twig', [
            'files' => $files,
        ]);
    }
}
