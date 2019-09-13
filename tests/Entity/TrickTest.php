<?php
namespace App\Tests\Entity;
use PHPUnit\Framework\TestCase;
use App\Entity\Trick;
use App\Entity\User;
use App\Entity\Video;
use App\Entity\Comment;

use App\Entity\Category;
use App\Entity\Illustration;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class TrickTest extends TestCase
{
    private $trick;
    private $illustrations;
    private $videos;
    private $comments;
    private $createdAt;

    public function setUp()
    {
        $this->trick = new Trick();
        $this->illustrations = [];
        $this->videos = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->createdAt = new \DateTime;

    }
    /**
     * @test
     */
    public function testGetName()
    {
        $this->trick->setName('nametrick');
        $result = $this->trick->getName();
        $this->assertSame('nametrick', $result);
    }
    /**
     * @test
     */
    public function testGetUser()
    {
        $this->trick->setUser(new User());
        $this->assertInstanceOf(User::class,$this->trick->getUser());
    }
    /**
     * @test
     */
    public function testGetCategory()
    {
        $this->trick->setCategory(new Category());
        $this->assertInstanceOf(Category::class,$this->trick->getCategory());
    }
    /**
     * @test
     */
    public function testGetDescription()
    {
        $this->trick->setDescription('description teste trick');
        $this->assertEquals($this->trick->getDescription(),'description teste trick');
    }
    /**
     * @test
     */
    public function testGetSlug()
    {
        $this->trick->setSlug('nemo-test-trick');
        $this->assertEquals($this->trick->getSlug(),'nemo-test-trick');
    }
    /**
     * @test
     */
    public function testGetUpdatedAt()
    {
        $this->trick->setUpdatedAt(new \DateTime());
        $this->assertInstanceOf(\DateTime::class,$this->trick->getUpdatedAt());
    }
    /**
     * @test
     */
    public function testGetCreatedAt()
    {
        $this->trick->setCreatedAt(new \DateTime());
        $this->assertInstanceOf(\DateTime::class,$this->trick->getCreatedAt());
    }
    /**
     * @test
     */
    public function testGetVideos()
    {
        $video = $this->createMock(Video::class);
        $this->trick->addVideo($video);
        $this->assertInstanceOf(ArrayCollection::class,$this->trick->getVideos());
    }
    /**
     * @test
     */
    public function testGetComments()
    {
        $video = $this->createMock(Comment::class);
        $this->trick->addComment($video);
        $this->assertInstanceOf(ArrayCollection::class,$this->trick->getComments());
    }
    /**
     * @test
     */
    public function testAddComments()
    {
        $comment = $this->createMock(Comment::class);
        $this->trick->addComment($comment);
        $this->assertContains($comment,$this->trick->getComments());
    }
    /**
     * @test
     */
    public function testAddVideo()
    {
        $video = $this->createMock(Video::class);
        $this->trick->addVideo($video);
        $this->assertContains($video,$this->trick->getVideos());
    }
}
