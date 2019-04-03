<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontArticleController extends AbstractController
{
    /**
     * @Route("/")
     * @return Response
     */
    public function list(): Response
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/article/{slug}")
     * @return Response
     */
    public function show(): Response
    {
        return $this->render('article/show.html.twig');
    }
}