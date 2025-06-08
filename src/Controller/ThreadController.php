<?php

namespace App\Controller;

use App\Entity\Threadtalk;
use App\Repository\ThreadtalkRepository;
use App\Form\ThreadtalkForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class ThreadController extends AbstractController
{
    #[Route('/threads', name: 'thread_list')]
    public function list(ThreadtalkRepository $repository): Response
    {
        return $this->render('thread/list.html.twig', [
            'threads' => $repository->findAll(),
        ]);
    }

    // Show a specific trend and ensures only numeric IDs are passed <\d+>
    #[Route('/threads/{id<\d+>}', name : 'thread_show')]
    public function show(Threadtalk $thread): Response
    {
        return $this->render('/thread/show.html.twig', [
            'thread' => $thread
        ]);
    }

    // Create a new trend
    #[Route('/thread/new', name: 'thread_new')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $thread = new Threadtalk();

        // Create a form for the Threadtalk entity
        $form = $this->createForm(ThreadtalkForm::class, $thread);

        // Handle the request and check if the form is submitted and valid
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($thread);

            // Save the new thread to the database
            $manager->flush();

            // Redirect to the thread list after successful creation
            return $this->redirectToRoute('thread_show', [
                'id' => $thread->getId(),
            ]);
        }

        return $this->render('thread/new.html.twig', [
            'form' => $form,
        ]);
    }
}
