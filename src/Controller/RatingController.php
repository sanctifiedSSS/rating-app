<?php

namespace App\Controller;

use App\Entity\Title;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class RatingController extends AbstractController
{
    /**
     * @Route("/title/{id}/rate?{score}", name="rate_title")
     * @param Request $request
     * @param int $id
     * @param int $score
     * @return Response
     */
    public function rateTitle(Request $request, int $id, int $score): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page. Please, sign in');

        $counter = 0;
        $ratedTitles = $this->getUser()->getRatedTitles();

        if (!empty($ratedTitles)){
            foreach ($ratedTitles as $key => $value){
                if ($key === $id) {
                    $ratedTitles[$id] = $score;
                    $counter++;
                }
            }
        }

        if ($counter === 0) {
            $ratedTitles += [$id => $score];
        }

        /** @var User $user */
        $user = $this->getUser()->setRatedTitles($ratedTitles);

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('show_title', [
            'id' => $id
        ]);
    }

}