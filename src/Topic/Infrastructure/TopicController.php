<?php

namespace App\Topic\Infrastructure;

use App\Topic\Domain\Entity\Topic;
use App\Topic\Domain\Repository\CommentRepository;
use App\Topic\Domain\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TopicController extends AbstractController
{
    #[Route('/topic/{id}', name: 'topic_show')]
    public function showTopic(Topic $topic, CommentRepository $commentRepo): Response
    {
        $comments = $commentRepo->findRootByTopic($topic->getId());

        return $this->render('topic/show.html.twig', [
            'topic' => $topic,
            'comments' => $comments,
        ]);
    }

    #[Route('/topic/{topicId}/comment/{commentId}', name: 'comment_show')]
    public function showComment(CommentRepository $commentRepository, TopicRepository $topicRepository, int $commentId, int $topicId): Response
    {
        $comment = $commentRepository->find($commentId);
        $topic = $topicRepository->find($topicId);

        if ($comment->getParent()) {
            throw $this->createNotFoundException();
        }

        return $this->render('topic/showComment.html.twig', [
            'comment' => $comment,
            'topic' => $topic
        ]);
    }
}
