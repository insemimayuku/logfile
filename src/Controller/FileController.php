<?php

namespace App\Controller;

use App\Entity\File;
use App\Form\FileUploadType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/files')]
class FileController extends AbstractController
{
    #[Route('/upload', name: 'app_upload')]
    public function upload(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(FileUploadType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['file']->getData();
            if ($uploadedFile) {
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();

                try {
                    $uploadedFile->move($this->getParameter('uploads_directory'), $newFilename);
                } catch (FileException $e) {
                    return new Response('Erreur lors de l\'upload', Response::HTTP_INTERNAL_SERVER_ERROR);
                }

                $file = new File();
                $file->setName($originalFilename);
                $file->setPath($newFilename);
                $file->setSize($uploadedFile->getSize());
                $file->setUploadDate(new \DateTime());
                $file->setUser($this->getUser());

                $entityManager->persist($file);
                $entityManager->flush();

                return $this->redirectToRoute('app_dashboard');
            }
        }

        return $this->render('files/upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'file_delete')]
    #[IsGranted('ROLE_USER')]
    public function delete(File $file, EntityManagerInterface $entityManager): Response
    {
        // Vérification si l'utilisateur est le propriétaire du fichier
        if ($this->getUser() !== $file->getUser()) {
            throw $this->createAccessDeniedException('Vous ne pouvez pas supprimer ce fichier.');
        }

        $filePath = $this->getParameter('uploads_directory') . '/' . $file->getPath();

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $entityManager->remove($file);
        $entityManager->flush();

        return $this->redirectToRoute('app_dashboard');
    }

}
