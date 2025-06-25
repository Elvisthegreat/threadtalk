<?php

namespace App\Controller;

use App\Entity\Threadtalk;
use App\Repository\ThreadtalkRepository;
use App\Form\ThreadtalkForm;
use App\Entity\Comment;
use App\Form\CommentTypeForm;
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
    public function show(Threadtalk $thread, Request $request, EntityManagerInterface $manager): Response
    {
        $comment = new Comment();
        $comment->setThread($thread);
        $comment->setAuthor($this->getUser());

        $form = $this->createForm(CommentTypeForm::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash('notice', 'Comment added!');
            return $this->redirectToRoute('thread_show', ['id' => $thread->getId()]);
        }

        return $this->render('thread/show.html.twig', [
            'thread' => $thread,
            'form' => $form->createView(),
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
            $this->addFlash('notice', 'Your thread has been created successfully.');

            // Redirect to the thread list after successful creation
            return $this->redirectToRoute('thread_show', [
                'id' => $thread->getId(),
            ]);
        }

        return $this->render('thread/new.html.twig', [
            'form' => $form,
        ]);
    }

    // Edit an existing thread
    #[Route('/thread/edit/{id<\d+>}', name: 'thread_edit')]
    public function edit(Threadtalk $thread, Request $request, EntityManagerInterface $manager): Response
    {
        // Create a form for the Threadtalk entity
        $form = $this->createForm(ThreadtalkForm::class, $thread);

        // Handle the request and check if the form is submitted and valid
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Update the thread in the database
            $manager->flush();

            $this->addFlash('notice', 'Your changes updated successfully.');

            // Redirect to the thread list after successful update
            return $this->redirectToRoute('thread_show');
        }

        return $this->render('thread/edit.html.twig', [
            'form' => $form,
        ]);
    }

    // Delete a thread
    #[Route('/thread/delete/{id<\d+>}', name: 'thread_delete')]
    public function delete(Threadtalk $thread, Request $request, EntityManagerInterface $manager): Response
    {
        // Check if method is POST
        if ($request->isMethod('POST')) {
            $manager->remove($thread);
            $manager->flush();
            $this->addFlash('notice', 'Your thread has been deleted successfully.');

            // Redirect to the thread list after successful deletion
            return $this->redirectToRoute('thread_list');
        }

        return $this->render('thread/delete.html.twig', [
            'id' => $thread->getId(),
        ]);
    }
}
