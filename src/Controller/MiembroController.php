<?php

namespace App\Controller;

use App\Entity\Miembro;
use App\Form\MiembroType;
use App\Repository\MiembroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/miembro')]
class MiembroController extends AbstractController
{
    #[Route('/', name: 'app_miembro_index', methods: ['GET'])]
    public function index(MiembroRepository $miembroRepository): Response
    {
        return $this->render('miembro/index.html.twig', [
            'miembros' => $miembroRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_miembro_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $miembro = new Miembro();
        $form = $this->createForm(MiembroType::class, $miembro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file almacena el archivo subido
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form['imagen']->getData();
            // Generamos un nombre único
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            // Move the file to the directory where brochures are stored
            $file->move($this->getParameter('images_directory_miembros'), $fileName);
            // Actualizamos el nombre del archivo en el objeto imagen al nuevo generado
            $miembro->setImagen($fileName);
            //Actualizamos el id del usuario que añade la imagen
            $entityManager->persist($miembro);
            $entityManager->flush();

            return $this->redirectToRoute('app_miembro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('miembro/new.html.twig', [
            'miembro' => $miembro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_miembro_show', methods: ['GET'])]
    public function show(Miembro $miembro): Response
    {
        return $this->render('miembro/show.html.twig', [
            'miembro' => $miembro,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_miembro_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Miembro $miembro, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MiembroType::class, $miembro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                                    // $file almacena el archivo subido
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form['imagen']->getData();
            // Generamos un nombre único
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            // Move the file to the directory where brochures are stored
            $file->move($this->getParameter('images_directory_miembros'), $fileName);
            // Actualizamos el nombre del archivo en el objeto imagen al nuevo generado
            $miembro->setImagen($fileName);
            //Actualizamos el id del usuario que añade la imagen
            $entityManager->flush();

            return $this->redirectToRoute('app_miembro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('miembro/edit.html.twig', [
            'miembro' => $miembro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_miembro_delete', methods: ['POST'])]
    public function delete(Request $request, Miembro $miembro, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$miembro->getId(), $request->request->get('_token'))) {
            $entityManager->remove($miembro);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_miembro_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
