<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commande")
 */
class CommandeController extends AbstractController
{
    /**
     * @Route("/", name="commande_index", methods={"GET"})
     */
    public function index(CommandeRepository $commandeRepository): Response
    {

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }
    /**
     * @Route("/commandelist",name="commandelist")
     */


    public function list()
    {
        $Commandes= $this->getDoctrine()->
        getRepository(Commande::class)->findAll();
        return $this->render("commande/index.html.twig",
            array('commandes'=>$Commandes));
    }


    /**
     * @Route("/new", name="commande_new", methods={"GET","POST"})
     */
    public function new(Request $request,SessionInterface $session, ProduitRepository   $gamesRepository): Response
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);
        $panier = $session->get('panier', []);
        $panierwithData = [];

        $total = 0;
        Foreach ($panier as $id => $quantity) {
            $product = $gamesRepository->find($id);
            $panierwithData[] = [


                'product' => $gamesRepository->find($id),
                'quantity' => $quantity
            ];
            $total += $product->getPrix() * $quantity;
        }

        if ($form->isSubmitted() && $form->isValid()) {
            for ($i = 0; $i < count($panierwithData ); $i++) {

                $commande->setProduct($panierwithData [$i]['product']->getNom());


                $commande->setTotalcost($total);}

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute('commandelist');
        }




        return $this->render('commande/new.html.twig',['commande' => $commande,'panierwithData' => $panierwithData,'total'=>$total,'form'=>$form->createView()]);
    }
}
