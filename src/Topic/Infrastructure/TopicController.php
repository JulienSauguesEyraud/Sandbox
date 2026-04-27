<?php

namespace App\Topic\Infrastructure;

use App\Topic\Domain\Entity\Comment;
use App\Topic\Domain\Entity\Topic;
use App\Topic\Domain\Repository\CommentRepository;
use App\User\Application\RegisterUser;
use App\User\Domain\Input\RegisterUserDTO;
use App\User\Domain\Repository\UserRepository;
use App\User\Infrastructure\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TopicController extends AbstractController
{
    #[Route('/topic/{id}', name: 'topic_show')]
    public function showTopic(Topic $topic, CommentRepository $commentRepo): Response
    {
        $comments = $commentRepo->findRootByTopic($topic);

        return $this->render('topic/show.html.twig', [
            'topic' => $topic,
            'comments' => $comments,
        ]);
    }

    #[Route('/topic/comment/{id}', name: 'comment_show')]
    public function showComment(Comment $comment, CommentRepository $repo): Response
    {
        if($comment->getParent()){
            throw $this->createNotFoundException('This comment is not a root comment.');
        }

        $topic = $comment->getTopic();

        $all = $repo->findBy(['topic' => $topic]);

        $indexed = [];

        foreach ($all as $c) {
            $indexed[$c->getId()] = [
                'comment' => $c,
                'children' => []
            ];
        }

        foreach ($indexed as $_ => &$node) {
            $parent = $node['comment']->getParent();

            if ($parent) {
                $indexed[$parent->getId()]['children'][] = &$node;
            }
        }

        $tree = $indexed[$comment->getId()];

        return $this->render('topic/showComment.html.twig', [
            'comment' => $comment,
            'tree' => $tree,
            'topic' => $topic,
        ]);
    }
}
