<?php
/**
 * The CommentController file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  CommentController
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Controller/CommentController
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Forms;
use App\Entity\Trick;
use App\Entity\Comment;

/**
 * This class allows to edit a snowtrick
 *
 * @category Class
 * @package  CommentController
 * @author   Samir <allabsamir777@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Controller/CommentController
 */
class CommentController extends AbstractController
{
    private $manager;
    /**
     * Initialisation of Object manager in the constructor
     *
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager=$manager;
    }
    /**
     * This method allow to delete a comment
     *
     * @param Comment $comment
     *
     * @return Response
     *
     * @Route("/member/snowtrick/delete-comment/{id}", name="delete_comment")
     */
    public function deleteComment(Comment $comment)
    {
        $this->manager->remove($comment);
        $this->manager->flush();
        return $this->redirectToRoute(
            'edit_trick',
            ['id'=>$comment->getTrick()->getId()]
        );
    }
    /**
     * This function allows to execute some instructions for save the comment
     *
     * @param Comment       $comment
     * @param ObjectManager $manager
     * @param Trick         $trick
     *
     * @return void
     */
    public function addComment(Comment $comment, Trick $trick)
    {
        $comment->setCommentedAt(new \DateTime);
        $comment->setTrick($trick);
        $comment->setUser($this->getUser());
        $this->manager->persist($comment);
        $this->manager->flush();
    }
}
