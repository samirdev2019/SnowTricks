<?php
/**
 * The TrickFixtures file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  TrickFixtures
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/DataFixtures/TrickFixtures.php
 */
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Trick;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Illustration;
use App\Entity\Video;

/**
 * The TrickFixtures class
 *
 * @category Class
 * @package  TrickFixtures
 * @author   Samir <allabsamir777@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/DataFixtures/TrickFixtures.php
 */
class TrickFixtures extends Fixture
{
    private $encoder;
    /**
     * The constructor class with intialisation of UserPasswordEncoderInterface
     *
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    /**
     * The method allows to load a fake information using faker
     *
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        $category = new Category();
        $category->setName($faker->sentence());
        $category->setDescription(
            $faker->realText($maxNbChars = 150, $indexSize = 2)
        );
        $manager->persist($category);
        $user = new User();
        $user->setUsername('username');
        $user->setEmail($faker->email());
        $user->setPassword($this->encoder->encodePassword($user, 'demo'));
        $user->setToken($faker->md5());
        $user->setIsValidated($faker->boolean());
        $user->setAvatar('avatarDefault.png');
        $user->setSubscribedAT($faker->dateTime());
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);
        for ($i = 1; $i <=10; $i++) {
            $trick = new Trick();
            $trick->setUser($user);
            $trick->setCategory($category);
            $trick->setName($faker->sentence());
            $content = '<p>'.join($faker->paragraphs(3), '</p><p>').'</p><p>';
            $trick->setDescription($content);
            $trick->setCreatedAt($faker->dateTime());
            $trick->setUpdatedAt($faker->dateTime());
            $manager->persist($trick);
            for ($j=1; $j<=5; $j++) {
                $comment = new Comment();
                $comment->setTrick($trick);
                $comment->setUser($user);
                $comment->setContent($faker->paragraph());
                $comment->setCommentedAt($faker->dateTime());
                $manager->persist($comment);
            }
            for ($k=1; $k<=3; $k++) {
                $image = new Illustration();
                $image->setTrick($trick);
                $image->setName($faker->name());
                $image->setUrl("fixtures$k.jpeg");
                $manager->persist($image);
            }
            for ($m=1; $m<=3; $m++) {
                $media = new Video();
                $media->setTrick($trick);
                $media->setPlatform("youtube");
                $media->setUrl('<iframe width="853" height="480" src="https://www.youtube.com/embed/V9xuy-rVj9w" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
                $manager->persist($media);
            }
        }
        $manager->flush();
    }
}
