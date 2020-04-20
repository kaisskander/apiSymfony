<?php


namespace App\DataFixtures;

use App\Entity\BlogPost;

use App\Entity\Comment;
use Faker;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
    * @var UserPasswordEncoderInterface
     */
    private $password;

    /**
     * @var Faker\Factory
     */
    private $faker;

    public function  __construct(UserPasswordEncoderInterface  $passwordEncoder)
    {
        $this->password = $passwordEncoder;
        $this->faker = Faker\Factory::create();

    }

    public function load(EntityManagerInterface $entityManager)
    {
        $this->loadUsers($entityManager);
        $this->loadBlogPosts($entityManager);
        $this->loadComments($entityManager);

    }

    public function loadBlogPosts(EntityManagerInterface $entityManager){

        $user = $this->getReference('user_admin');
         for ($i = 0; $i <50; $i++) {
            $blogPost = new BlogPost();
            $blogPost->setTitle($this->faker->realText(30))
                ->setPublished($this->faker->dateTimeThisYear)
                ->setContent($this->faker->realText())
                ->setAuthor($user)
                ->setSlug($this->faker->slug);
            $this->setReference("blog_post_$i",$blogPost);
            $entityManager->persist($blogPost);
            }
        $entityManager->flush();
    }

    public function loadComments(EntityManagerInterface $entityManager){
        for ($i=0 ;$i<50; $i++){
            for ($j=0;$j<rand(1,10); $j++){
                $comment = new Comment();
                $comment->setContent($this->faker->realText())
                    ->setPublished($this->faker->dateTimeThisYear)
                    ->setAuthor($this->getReference('user_admin'))
                ->setBlogPost($this->getReference("blog_post_$i"));

                $entityManager->persist($comment);
            }
        }
        $entityManager->flush();
    }

    public function loadUsers(EntityManagerInterface $entityManager){
        $user = new User();
        $user->setName('kais')
            ->setEmail('kais@gmail.com')
            ->setUsername('kais skander')
            ->setPassword($this->password->encodePassword($user,'blabla123'))
        ;

        $this->addReference('user_admin',$user);

        $entityManager->persist($user);
        $entityManager->flush();

    }



}
