<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\RegistrationFormType;

#[Route('/profile')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'sym_profile')]
    public function profile(UserRepository $usuarioRepository)
    {
        $user = $this->getUser();
        $usuario = $usuarioRepository->findUsuario($user->getUserIdentifier());
        return $this->render('profile.html.twig', ['usuario' => $usuario]);
    }
    #[Route('/edit', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    public function avatar(UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $usuario = $userRepository->findUsuario($user->getUserIdentifier());
        $form = $this->createForm(RegistrationFormType::class, $usuario);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form['user_image']->getData();
            // Generamos un nombre único
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            // Move the file to the directory where brochures are stored
            $file->move($this->getParameter('images_directory_user'), $fileName);
            // Actualizamos el nombre del archivo en el objeto imagen al nuevo generado
            $usuario->setUserImage($fileName);
            //Actualizamos el id del usuario que añade la imagen
            $entityManager->flush();
            // encode the plain password
            $usuario->setPassword(
                $userPasswordHasher->hashPassword(
                    $usuario,
                    $form->get('plainPassword')->getData()
                )
            );
            return $this->redirectToRoute('sym_index');
        }
        $entityManager->flush();
        return $this->render('profileedit.html.twig', [
            'form' => $form,
        ]);
    }
}
