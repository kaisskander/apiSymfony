<?php


namespace App\DataFixtures;

use App\Entity\BlogPost;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;

class AppFixtures extends Fixture
{
    public function load(EntityManagerInterface $entityManager)
    {
        $this->loadUsers($entityManager);
        $this->loadBlogPosts($entityManager);

    }

    public function loadBlogPosts(EntityManagerInterface $entityManager){

        $user = $this->getReference('kais');

        $blogPost = new BlogPost();
        $blogPost->setTitle("haka")
            ->setPublished( new \DateTime('2020-04-20 12:00:00'))
            ->setContent('post text')
            ->setAuthor($user)
            ->setSlug('a-frist-post');

        $entityManager->persist($blogPost);



        $blogPost = new BlogPost();
        $blogPost->setTitle("haka")
            ->setPublished( new \DateTime('2020-04-20 12:00:00'))
            ->setContent('post text')
            ->setAuthor($user)
            ->setSlug('a-second-post');

        $entityManager->persist($blogPost);

        $entityManager->flush();
    }

    public function loadComments(EntityManagerInterface $entityManager){

    }

    public function loadUsers(EntityManagerInterface $entityManager){
        $user = new User();
        $user->setName('kais')
            ->setEmail('kais@gmail.com')
            ->setUsername('kais skander')
            ->setPassword('blabla123')
        ;

        $this->addReference('kais',$user);

        $entityManager->persist($user);
        $entityManager->flush();

    }



}
