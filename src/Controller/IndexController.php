<?php

namespace App\Controller;

use App\Topic\Domain\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    #[Route('/', name: 'app_root')]
    public function index(TopicRepository $topicRepository): Response
    {
        return $this->render('index/index.html.twig',
            ['topics' => $topicRepository->findAll()]
        );
    }
}
