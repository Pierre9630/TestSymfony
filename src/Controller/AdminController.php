<?php

namespace App\Controller;

use App\Entity\OpeningHours;
use App\Entity\Products;
use App\Entity\User;
use App\Form\OpeningHoursFormType;
use App\Form\UserFormType;
use App\Form\AdminFormType;
use App\Repository\OpeningHoursRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin_index')]
    public function index(UserRepository $userRepository, EntityManagerInterface $entityManager, Request $request, PaginatorInterface $paginator): Response
    {
        $repository = $entityManager->getRepository(Products::class);
        //$user = $userRepository->findAll();
        $pagination = $paginator->paginate(
            $userRepository->paginateUsers(),
            $request->query->get('page',1),
            5
        );
        
        return $this->render('admin/index.html.twig', [
            'users' => $pagination,
            'admins' => $userRepository->foundAdmins(),
            'products'=>$repository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository,UserPasswordHasherInterface $userPasswordHasher ): Response
    {
        $admin = new User();
        $form = $this->createForm(AdminFormType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $admin->setPassword(
                $userPasswordHasher->hashPassword(
                    $admin,
                    $form->get('password')->getData()
                )
            );
            $userRepository->save($admin, true);

            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/new.html.twig', [
            'user' => $admin,
            'form' => $form,

        ]);
    }

    #[Route('/openinghours', name: 'app_admin_oh', methods: ['GET','POST'])]
    public function showmodifyoh(Request $request,  OpeningHoursRepository $openingHoursRepository): Response
    {
        //dd('test');
        $oh = new OpeningHours();
        $form = $this->createForm(OpeningHoursFormType::class, $oh);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $openingHoursRepository->save($oh, true);

            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/oh.html.twig', [
            'form'=>$form,
            'oh' => $openingHoursRepository->findAll(),
        ]);
    }

    #[Route('/openinghours/{id}', name: 'app_admin_oh_delete', methods: ['GET','POST'])]
    public function deleteoh(Request $request, OpeningHours $oh, OpeningHoursRepository $openingHoursRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$oh->getId(), $request->request->get('_token'))) {
            $openingHoursRepository->remove($oh, true);
        }

        return $this->redirectToRoute('app_admin_oh', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/{id}', name: 'app_admin_show', methods: ['GET'])]
    public function show(User $admin): Response
    {
        return $this->render('admin/show.html.twig', [
            'user' => $admin,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $admin, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserFormType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($admin, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/edit.html.twig', [
            'user' => $admin,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_delete', methods: ['POST'])]
    public function delete(Request $request, User $admin, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$admin->getId(), $request->request->get('_token'))) {
            $userRepository->remove($admin, true);
        }

        return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
    }





}


