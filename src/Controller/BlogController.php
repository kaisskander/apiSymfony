<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Repository\BlogPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/blog")
 */

class BlogController extends AbstractController
{

    private const POSTS = [
        [
        'id'=>1,
        'slug'=>'hello-world',
        'title'=> 'hello world'
        ],
        [
            'id'=>2,
        'slug'=>'another-post',
        'title'=> 'This is another post!'
        ],
        [
            'id'=>3,
        'slug'=>'last-exemple',
        'title'=> 'this is last example'
        ]
    ];

    /**
     *@Route("/add",name="blog_add" , methods={"POST"})
     */
    public function add(Request $request){
        /**@var  Serializer $serializer*/
        $serializer = $this->get('serializer');
        $blogPost = $serializer->deserialize($request->getContent(),BlogPost::class,'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($blogPost);
        $em->flush();

        return $this->json($blogPost);
    }

    /**
     *@Route("/{page}",name="blog_list",defaults={"page":5},requirements={"page"="\d+"})
     */
    public function list($page = 1,Request $request,BlogPostRepository $blogPostRepository){
        $limit =$request->get('limit',20);
        $items = $blogPostRepository->findAll();
        return $this->json(
            [
                'page' => $page,
                'limit'=> $limit,
                'data'=> array_map(function (blogPost $item){
                    return $this->generateUrl('blog_by_slug',['slug'=>$item->getSlug()]);
                },$items)
            ]
        );
    }

    /**
     *@Route("/post/{id}",name="blog_by_id",requirements={"id"="\d+"},methods={"GET"})
     */
    public function post(BlogPost $post){
        return $this->json($post);

    }

    /**
     *@Route("/post/{slug}",name="blog_by_slug",methods={"GET"})
     */
    public function postBySlug(BlogPost $post){
        return $this->json($post);

    }


    /**
    * @Route("/post/{id}",name="blog_delete",methods={"DELETE"})
     */
    public function delete(BlogPost $post,EntityManagerInterface  $entityManager)
    {
        $entityManager->remove($post);
        $entityManager->flush();
        return new JsonResponse(null,Response::HTTP_NO_CONTENT);

    }

}