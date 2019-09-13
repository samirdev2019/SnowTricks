<?php
namespace App\Tests\Form;

use App\Form\CommentType;
use App\Entity\Comment;
use App\Entity\User;
use App\Entity\Trick;
use Symfony\Component\Form\Test\TypeTestCase;

class TrickCommentTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $user = $this->createMock(User::class);
        $trick = $this->createMock(Trick::class);
        
        $formData = [
            'content' => 'testMessage',     
        ];

        $objectToCompare = $this->createMock(Comment::class);
        $form = $this->factory->create(CommentType::class, $objectToCompare);
        $comment = $this->createMock(Comment::class);
        $comment->setUser($user);
        $comment->setContent('testMessage');
        $comment->setTrick($trick);
        
        
        // submit the data to the form directly
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());

        // check that $objectToCompare was modified as expected when the form was submitted
        $this->assertEquals($comment, $objectToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }    
}
