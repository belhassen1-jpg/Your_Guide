<?php

namespace App\Controller;
use App\Entity\Activite;
use App\Form\ActiviteType;
use App\Repository\ActiviteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use MercurySeries\FlashyBundle\FlashyNotifier;


/**
 * @Route("/activite")
 */
class ActiviteController extends AbstractController
{
    /**
     * @Route("/", name="activite_index", methods={"GET"})
     */
    public function index(ActiviteRepository $activiteRepository): Response
    {
        return $this->render('activite/index.html.twig', [
            'activites' => $activiteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/back", name="activite_index2", methods={"GET"})
     */
    public function index2(ActiviteRepository $activiteRepository): Response
    {
        return $this->render('activite/indexback.html.twig', [
            'activites' => $activiteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="activite_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $activite = new Activite();
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ImageFile = $form->get('image')->getData();
            if ($ImageFile) {
                $newFilename = md5(uniqid()).'.'.$ImageFile->guessExtension();
                $destination = $this->getParameter('kernel.project_dir').'/public/images/activite';

                try {
                    $ImageFile->move(
                        $destination,
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                    // updates the 'ImageFilename' property to store the PDF file name
                     // instead of its contents
                $activite->setImage($newFilename);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($activite);
            $entityManager->flush();

            return $this->redirectToRoute('activite_index2', [], Response::HTTP_SEE_OTHER);

        }

        return $this->render('activite/new.html.twig', [
            'activite' => $activite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/TrierParNomDESCr", name="TrierParNomDESCr")
     */
    public function TrierParNomr(Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Activite::class);
        $activites = $repository->findByNamer();

        return $this->render('activite/index.html.twig', [
            'activites' => $activites,
        ]);
    }
    /**
     * @Route("/TrierParNomASCr", name="TrierParNomASCr")
     */
    public function TrierParNomdesr(Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Activite::class);
        $activites = $repository->findByNameascr();

        return $this->render('activite/index.html.twig', [
            'activites' => $activites,
        ]);
    }


    /**
     * @Route("/TrierParNomDESCr2", name="TrierParNomDESCr2")
     */
    public function TrierParNomr2(Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Activite::class);
        $activites = $repository->findByNamer();

        return $this->render('activite/indexback.html.twig', [
            'activites' => $activites,
        ]);
    }
    /**
     * @Route("/TrierParNomASCr2", name="TrierParNomASCr2")
     */
    public function TrierParNomdesr2(Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Activite::class);
        $activites = $repository->findByNameascr();

        return $this->render('activite/indexback.html.twig', [
            'activites' => $activites,
        ]);
    }

    /**
     * @Route("/{id}", name="activite_show", methods={"GET"})
     */
    public function show(Activite $activite): Response
    {
        return $this->render('activite/show.html.twig', [
            'activite' => $activite,
        ]);
    }
    /**
     * @Route("/back/{id}", name="activite_show2", methods={"GET"})
     */
    public function show2(Activite $activite): Response
    {
        return $this->render('activite/showback.html.twig', [
            'activite' => $activite,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="activite_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Activite $activite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ImageFile = $form->get('image')->getData();
            if ($ImageFile) {

                // this is needed to safely include the file name as part of the URL

                $newFilename = md5(uniqid()).'.'.$ImageFile->guessExtension();
                $destination = $this->getParameter('kernel.project_dir').'/public/images/activite';
                // Move the file to the directory where brochures are stored
                try {
                    $ImageFile->move(
                        $destination,
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'ImageFilename' property to store the PDF file name
                // instead of its contents
                $activite->setImage($newFilename);
            }
            $this->getDoctrine()->getManager()->flush();
            $entityManager->flush();

            return $this->redirectToRoute('activite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('activite/edit.html.twig', [
            'activite' => $activite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="activite_delete", methods={"POST"})
     */
    public function delete(Request $request, Activite $activite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activite->getId(), $request->request->get('_token'))) {
            $entityManager->remove($activite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('activite_index2', [], Response::HTTP_SEE_OTHER);
    }
}
