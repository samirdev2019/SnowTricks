<?php
/**
 * The CommentManager file doc comment
 * 
 * PHP version 7.2.10 
 * 
 * @category Class
 * @package  CommentManager
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Services/CommentManager.php
 */
namespace App\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Forms;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Entity\Trick;

/**
 * This class use like as a sevice
 * 
 * @category Class
 * @package  CommentManager
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Services/CommentManager.php
 */
class CommentManager extends AbstractController
{

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
    public function addComment(Comment $comment, ObjectManager $manager,
        Trick $trick
    ) {
        $comment->setCommentedAt(new \DateTime);
        $comment->setTrick($trick);
        $comment->setUser($this->getUser());
        $manager->persist($comment);
        $manager->flush();  
    }
}
