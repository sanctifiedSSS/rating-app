<?php

namespace App\Controller;

use App\Entity\Title;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param Request $request
     * @return Response
     */
    public function goHome(Request $request) : Response
    {
        $titles = $this->getDoctrine()
            ->getManager()
            ->getRepository(Title::class)
            ->findAll();

        return $this->render("home.html.twig", [
            'titles' => $titles
        ]);
    }
}