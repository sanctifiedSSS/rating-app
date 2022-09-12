<?php

namespace App\Controller;

use App\Entity\Title;
use App\Type\TitleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class TitleController extends AbstractController
{
    /**
     * @Route("/title/create", name="title_create")
     * @param Request $request
     * @return Response
     */
    public function createTitle(Request $request): Response
    {
        $title = new Title();
        $form = $this->createForm(TitleType::class, $title);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $coverFile = $form->get('cover')->getData();

            if ($coverFile) {

                $originalFilename = pathinfo($coverFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $coverFile->guessExtension();

                try {
                    $coverFile->move(
                        $this->getParameter('covers_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    //
                }

                $title->setCoverFilename($newFilename);
            }

                $this->getDoctrine()->getManager()->persist($title);
                $this->getDoctrine()->getManager()->flush();

                $id = $title->getId();

                return $this->redirectToRoute('show_title', [
                    'id' => $id
                ]);
            }

            return $this->render("title/create.html.twig", [
                'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/title/{id}", name="show_title")
     * @param int $id
     * @return Response
     */
    public function showTitle(int $id): Response
    {
        $title = $this->getDoctrine()->getManager()->find(Title::class, $id);

        if ($title === null) {
            throw $this->createNotFoundException(sprintf("Title with id %s not found", $id));
        }

        return $this->render("title/title.html.twig", [
            'title' => $title
        ]);
    }

}