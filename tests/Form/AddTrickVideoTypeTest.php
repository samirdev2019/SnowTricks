<?php
namespace App\Tests\Form;

use App\Form\VideoType;
use App\Entity\Video;
use App\Entity\Trick;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

class AddTrickVideoTypeTest extends TypeTestCase
{
    private $objectManager;

    protected function setUp()
    {
        // mock any dependencies
        $this->objectManager = $this->createMock(ObjectManager::class);

        parent::setUp();
    }

    protected function getExtensions()
    {
        // create a type instance with the mocked dependencies
        $type = new VideoType($this->objectManager);

        return [
            // register the type instances with the PreloadedExtension
            new PreloadedExtension([$type], []),
        ];
    }
    public function testSubmitValidData()
    {
        $trick = $this->createMock(Trick::class);        
        $formData =[
            'url' => 'test',  
        ];

        $objectToCompare = new Video();
        // $objectToCompare will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(VideoType::class, $objectToCompare);
        $video = new Video();
        $video->setUrl('test');
        

        // ...populate $object properties with the data stored in $formData

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        // check that $objectToCompare was modified as expected when the form was submitted
        $this->assertEquals($video, $objectToCompare);

        $this->assertInstanceOf(Video::class, $form->getData());
    }
}