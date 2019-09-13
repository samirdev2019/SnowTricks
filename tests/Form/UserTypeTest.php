<?php
namespace App\Tests\Form;

use App\Form\UserType;
use App\Entity\User;
use Symfony\Component\Form\Test\TypeTestCase;

class UserTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        
        $formData = [
            'username' => 'testname',
            'email' => 'teste@email.com',
            'password' => 'password',
            'confirmation'  => 'password' 
        ];

        $userToCompare = $this->createMock(User::class);
        $form = $this->factory->create(UserType::class, $userToCompare);
        $user = $this->createMock(User::class);
        $user->setUsername('testname');
        $user->setEmail('teste@email.com');
        $user->setPassword('password');
        $user->setToken('cjkcdockcoomdk22cokdco');
        $user->setIsValidated(true);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($user, $userToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }    
}
