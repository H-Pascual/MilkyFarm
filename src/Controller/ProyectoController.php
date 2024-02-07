<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\BLL\ImagenBLL;
use App\Entity\User;
use App\Repository\ImagenRepository;
use App\Repository\MiembroRepository;
use App\Repository\ProductoRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ProyectoController extends AbstractController
{
    #[Route('/', name: 'sym_index')]
    public function index(ImagenRepository $imagenesRepository, ProductoRepository $productosRepository, MiembroRepository $miembrosRepository) {
        $imagenes = $imagenesRepository->findAll();
        $productos = $productosRepository->findAll();
        $miembros = $miembrosRepository->findAll();
        shuffle($imagenes);
        shuffle($productos);
        shuffle($miembros);
        return $this->render('index.html.twig', [
            'imagenes' => $imagenes,
            'productos' => $productos,
            'miembros' => $miembros
        ]);
    }
    #[Route('/contact', name: 'sym_contact')]
    public function contact()
    {
        return $this->render('contact.html.twig');
    }

    #[Route('/modifyusers', name: 'app_modify_users', methods: ['GET'])]
    public function modify(UserRepository $usuarioRepository)
    {
        $usuarios = $usuarioRepository->findAll();
        return $this->render('modifyusers.html.twig', ['usuarios' => $usuarios]);
    }

    #[Route('/modifyusers/{id}', name: 'app_modify_users_rol', methods: ['GET', 'POST'])]
    public function modify_rol(User $usuario, EntityManagerInterface $entityManager): Response
    {
        $roles[] = $usuario->getRoles();
        $checkRoles[] = ["ROLE_ADMIN", "ROLE_USER"];
        if($roles === $checkRoles){
            $roles[0] = 'ROLE_USER';
        } else{
            $roles[0] = 'ROLE_ADMIN';
        }
        $usuario->setRoles($roles);
        $entityManager->flush();
        return $this->redirectToRoute('app_modify_users');
    }

    #[Route('/modifyusers/delete/{id}', name: 'app_modify_users_delete', methods: ['GET', 'POST'])]
    public function modify_delete(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager, $id): Response
    {
        $user = $userRepository->find($id);
        if($user){
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_modify_users');
    }
}
