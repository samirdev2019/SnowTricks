<?php
namespace App\Tests\Form;

use App\Form\DescriptionType;
use App\Entity\Category;
use App\Entity\User;
use App\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;


class UpdateTrickTypeTest extends TypeTestCase
{
    private $objectManager;
    private $category;
    private $user;
    private $illustrations;
    private $videos;
    private $updatedAt;
    private $createdAt;
    protected function setUp()
    {
        // mock any dependencies
        $this->objectManager = $this->createMock(ObjectManager::class);
        $this->category = $this->createMock(Category::class);
        $this->user = $this->createMock(User::class);
        $this->updatedAt = new \DateTime();
        $this->createdAt = new \DateTime();
        parent::setUp(); 
    }

    protected function getExtensions()
    {
        // create a type instance with the mocked dependencies
        $type = new DescriptionType($this->objectManager);

        return [
            // register the type instances with the PreloadedExtension
            new PreloadedExtension([$type], []),
        ];
    }

    public function testSubmitValidData()
    {
        // Instead of creating a new instance, the one created in
        // getExtensions() will be used.
        $formData =[
            'name' => 'test',
            'category' => $this->category,
            'description'=> 'test2'
              
        ];

        $form = $this->factory->create(DescriptionType::class);
        // $trickToCompare will recieve the new infos when the form was submitted 
        $trickToCompare = new Trick();
        $trickToCompare->setUser($this->user);
        $trickToCompare->setCreatedAt($this->createdAt);
        $trickToCompare->setUpdatedAt($this->updatedAt);
        $trickToCompare->setSlug('test');

        $form = $this->factory->create(DescriptionType::class, $trickToCompare);

        $trick = new Trick();
        $trick->setName('test');
        $trick->setDescription('test2');
        //$trick->setCategory($this->category);
        $trick->setUser($this->user);
        $trick->setCreatedAt($this->createdAt);
        $trick->setUpdatedAt($this->updatedAt);
        $trick->setSlug('test');


         $form->submit($formData);
        $this->assertTrue($form->isSynchronized());

        // check that $objectToCompare was modified as expected when the form was submitted
        $this->assertEquals($trick,$trickToCompare);

        $this->assertInstanceOf(Trick::class, $form->getData());
    } 
}
