<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Form\ProductoType;
use App\Repository\ProductoRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/producto')]
class ProductoController extends AbstractController
{
    #[Route('/', name: 'app_producto_index', methods: ['GET'])]
    public function index(ProductoRepository $productoRepository, UserRepository $usuarioRepository): Response
    {
        $user = $this->getUser();
        if($user){
            $usuario = $usuarioRepository->findUsuario($user->getUserIdentifier());
            return $this->render('producto/index.html.twig', [
                'productos' => $productoRepository->findAll(),
                'usuario' => $usuario,
            ]);
        } else{
            return $this->render('producto/index.html.twig', ['productos' => $productoRepository->findAll()]);
        }

    }

    #[Route('/new', name: 'app_producto_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $producto = new Producto();
        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request);
        $producto->setUsuario($this->getUser());
        if ($form->isSubmitted() && $form->isValid()) {
                        // $file almacena el archivo subido
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form['imagen']->getData();
            // Generamos un nombre único
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            // Move the file to the directory where brochures are stored
            $file->move($this->getParameter('images_directory_productos'), $fileName);
            // Actualizamos el nombre del archivo en el objeto imagen al nuevo generado
            $producto->setImagen($fileName);
            //Actualizamos el id del usuario que añade la imagen
            $entityManager->persist($producto);
            $entityManager->flush();
            return $this->redirectToRoute('app_producto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('producto/new.html.twig', [
            'producto' => $producto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_producto_show', methods: ['GET'])]
    public function show(Producto $producto, UserRepository $usuarioRepository): Response
    {
        $user = $this->getUser();
        if($user){
            $usuario = $usuarioRepository->findUsuario($user->getUserIdentifier());
            return $this->render('producto/show.html.twig', [
                'producto' => $producto,
                'usuario' => $usuario,
            ]);
        } else {
            return $this->render('producto/show.html.twig', [
                'producto' => $producto,
            ]);
        }

    }

    #[Route('/{id}/edit', name: 'app_producto_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Producto $producto, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request);
        $producto->setUsuario($this->getUser());
        if ($form->isSubmitted() && $form->isValid()) {
            // $file almacena el archivo subido
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form['imagen']->getData();
            // Generamos un nombre único
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            // Move the file to the directory where brochures are stored
            $file->move($this->getParameter('images_directory_productos'), $fileName);
            // Actualizamos el nombre del archivo en el objeto imagen al nuevo generado
            $producto->setImagen($fileName);
            //Actualizamos el id del usuario que añade la imagen
            $entityManager->flush();

            return $this->redirectToRoute('app_producto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('producto/edit.html.twig', [
            'producto' => $producto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_producto_delete', methods: ['POST'])]
    public function delete(Request $request, Producto $producto, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$producto->getId(), $request->request->get('_token'))) {
            $entityManager->remove($producto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_producto_index', [], Response::HTTP_SEE_OTHER);
    }
}
