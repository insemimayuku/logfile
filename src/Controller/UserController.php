<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/delete', name: 'user_delete', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function deleteUser(EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Récupére et supprime tous les fichiers de l'utilisateur
        $fileRepository = $entityManager->getRepository(File::class);
        $files = $fileRepository->findBy(['user' => $user]);
        $fileCount = count($files);
        
        foreach ($files as $file) {
            $filePath = $this->getParameter('uploads_directory') . '/' . $file->getPath();
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $entityManager->remove($file);
        }

        // Supprime l'utilisateur
        $userName = $user->getFirstName() . ' ' . $user->getLastName();
        $userEmail = $user->getEmail();
        $entityManager->remove($user);
        $entityManager->flush();

        // Envoie un email de confirmation à l'utilisateur
        $userEmailMessage = (new Email())
            ->from('no-reply@votre-site.com')
            ->to($userEmail)
            ->subject('Suppression de votre compte')
            ->html("<p>Bonjour $userName,</p><p>Votre compte a été supprimé avec succès.</p>");
        $mailer->send($userEmailMessage);

        // Envoie un email à l'admin
        $adminEmail = 'admin@votre-site.com';
        $adminEmailMessage = (new Email())
            ->from('no-reply@votre-site.com')
            ->to($adminEmail)
            ->subject('Un utilisateur a supprimé son compte')
            ->html("<p>L'utilisateur <strong>$userName</strong> ($userEmail) a supprimé son compte.</p><p>Nombre de fichiers supprimés : <strong>$fileCount</strong>.</p>");
        $mailer->send($adminEmailMessage);

        // Déconnecte l'utilisateur après suppression
        return $this->redirectToRoute('app_logout');
    }

    #[Route('/settings', name: 'user_settings')]
    #[IsGranted('ROLE_USER')]
    public function settings(): Response
    {
        return $this->render('user/settings.html.twig');
    }
}
