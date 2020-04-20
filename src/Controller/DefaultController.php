<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
    * @Route("/",name="default_index")
     */

    public function index () {
    return new JsonResponse([
        'action'=>'index',
        'time'=>time()
    ]);
    }
}