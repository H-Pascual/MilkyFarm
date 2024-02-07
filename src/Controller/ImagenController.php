<?php

namespace App\Controller;

use App\BLL\ImagenBLL;
use App\Entity\Imagen;
use App\Form\ImagenType;
use App\Repository\ImagenRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/imagen')]
class ImagenController extends AbstractController
{
    #[Route('/', name: 'app_imagen_index', methods: ['GET'])]
    #[Route('/orden/{ordenacion}', name: 'app_imagen_index_ordenado', methods: ['GET'])]
    public function index(
        ImagenBLL $imagenBLL,
        string $ordenacion = null,
        ImagenRepository $imagenesRepository,
        UserRepository $usuarioRepository
    ): Response {
        $imagenes = $imagenesRepository->findAll();
        $user = $this->getUser();
        if($user){
            $imagenes = $imagenBLL->getImagenesConOrdenacion($ordenacion);
            $usuario = $usuarioRepository->findUsuario($user->getUserIdentifier());
            return $this->render('imagen/index.html.twig', [
                'imagenes' => $imagenes,
                'usuario' => $usuario,
            ]);
        } else {
            return $this->render('imagen/index.html.twig', [
                'imagenes' => $imagenes
            ]);
        }
    }

    #[Route('/new', name: 'app_imagen_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $imagen = new Imagen();
        $form = $this->createForm(ImagenType::class, $imagen);
        $form->handleRequest($request);
        $imagen->setUsuario($this->getUser());
        if ($form->isSubmitted() && $form->isValid()) {
            // $file almacena el archivo subido
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form['nombre']->getData();
            // Generamos un nombre único
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            // Move the file to the directory where brochures are stored
            $file->move($this->getParameter('images_directory_gallery'), $fileName);
            // Actualizamos el nombre del archivo en el objeto imagen al nuevo generado
            $imagen->setNombre($fileName);
            //Actualizamos el id del usuario que añade la imagen
            $usuario = $this->getUser();
            $imagen->setUsuario($usuario);
            $entityManager->persist($imagen);
            $entityManager->flush();
            $this->addFlash('mensaje', 'Se ha creado la imagen ' . $imagen->getNombre());
            return $this->redirectToRoute('app_imagen_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('imagen/new.html.twig', [
            'imagen' => $imagen,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_imagen_show', methods: ['GET'])]
    public function show(Imagen $imagen, UserRepository $usuarioRepository): Response
    {
        $user = $this->getUser();
        if($user){
            $usuario = $usuarioRepository->findUsuario($user->getUserIdentifier());
            return $this->render('imagen/show.html.twig', [
                'imagen' => $imagen,
                'usuario' => $usuario,
            ]);
        } else {
            return $this->render('imagen/show.html.twig', [
                'imagen' => $imagen
            ]);
        }
    }

    #[Route('/{id}/edit', name: 'app_imagen_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Imagen $imagen, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ImagenType::class, $imagen);
        $form->handleRequest($request);
        $imagen->setUsuario($this->getUser());
        if ($form->isSubmitted() && $form->isValid()) {
            // $file almacena el archivo subido
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form['nombre']->getData();
            // Generamos un nombre único
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            // Move the file to the directory where brochures are stored
            $file->move($this->getParameter('images_directory_gallery'), $fileName);
            // Actualizamos el nombre del archivo en el objeto imagen al nuevo generado
            $imagen->setNombre($fileName);
            //Actualizamos el id del usuario que añade la imagen
            $entityManager->flush();

            return $this->redirectToRoute('app_imagen_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('imagen/edit.html.twig', [
            'imagen' => $imagen,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_imagen_delete', methods: ['POST'])]
    public function delete(Request $request, Imagen $imagen, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $imagen->getId(), $request->request->get('_token'))) {
            $entityManager->remove($imagen);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_imagen_index', [], Response::HTTP_SEE_OTHER);
    }
}
