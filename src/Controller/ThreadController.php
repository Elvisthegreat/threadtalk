<?php

namespace App\Controller;

use App\Entity\Threadtalk;
use App\Repository\ThreadtalkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ThreadController extends AbstractController
{
    #[Route('/threads', name: 'thread_list')]
    public function list(ThreadtalkRepository $repository): Response
    {
        return $this->render('thread/list.html.twig', [
            'threads' => $repository->findAll(),
        ]);
    }

    // Show a specific thread and ensures only numeric IDs are passed <\d+>
    #[Route('/threads/{id<\d+>}', name : 'thread_show')]
    public function show(Threadtalk $thread): Response
    {
        return $this->render('/thread/show.html.twig', [
            'thread' => $thread
        ]);
    }
}
