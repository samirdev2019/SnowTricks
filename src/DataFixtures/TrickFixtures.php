<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Trick;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Illustration;
use App\Entity\Video;

class TrickFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        $category = new Category();
        $category->setName($faker->sentence());
        $category->setDescription($faker->paragraph());

        $manager->persist($category);

        $user = new User();
        $user->setUsername($faker->userName());
        $user->setEmail($faker->email());
        $user->setPassword($faker->password());
        $user->setToken($faker->md5());
        $user->setIsValidated($faker->boolean());
        $user->setAvatar($faker->imageUrl());
        $user->setSubscribedAT($faker->dateTime());
        $manager->persist($user);
        for($i = 1; $i <=10; $i++) {
            $trick = new Trick();
            $trick->setUser($user);
            $trick->setCategory($category);
            $trick->setName($faker->sentence());
            $trick->setDescription($faker->paragraph());
            $trick->setCreatedAt($faker->dateTime());
            $trick->setUpdatedAt($faker->dateTime());
            
            $manager->persist($trick);

            for($j=1; $j<=5; $j++) {
                $comment = new Comment();
                $comment->setTrick($trick);
                $comment->setUser($user);
                $content = '<p>'.join($faker->paragraphs(3),'</p><p>').'</p><p>';
                $comment->setContent($content);
                $comment->setCommentedAt($faker->dateTime());
                
                $manager->persist($comment);
            }
            for($k=1; $k<=3; $k++) {
                $image = new Illustration();
                $image->setTrick($trick);
                $image->setName($faker->name());
                $image->setUrl($faker->imageUrl());
               
                $manager->persist($image);
            }
            for($m=1; $m<=3; $m++) {
                $media = new Video();
                $media->setTrick($trick);
                $media->setPlatform($faker->name());
                $media->setUrl($faker->mimeType());
                
                $manager->persist($media);
            }
        }

        $manager->flush();
    }
}
