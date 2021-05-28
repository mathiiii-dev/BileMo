<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="api_product")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->json(["message" => "ça marche", "user" => $user->getUsername()], 200);
    }
}
