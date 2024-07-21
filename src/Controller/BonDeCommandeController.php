<?php

namespace App\Controller;

use App\Entity\BonDeCommande;
use App\Entity\Produit;
use App\Form\BonDeCommandeType;
use App\Repository\BonDeCommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Security as CoreSecurity;

#[Route('/bon/de/commande')]
class BonDeCommandeController extends AbstractController
{
    #[Route('/', name: 'app_bon_de_commande_index', methods: ['GET'])]
    public function index(BonDeCommandeRepository $bonDeCommandeRepository,CoreSecurity $security): Response
    {
        $user = $security->getUser();
        return $this->render('bon_de_commande/index.html.twig', [
            'bon_de_commandes' => $bonDeCommandeRepository->findBy(['User'=>$user]),
        ]);
    }
    #[Route('/i', name: 'app_bon_de_commande_indexb', methods: ['GET'])]
    public function index1(BonDeCommandeRepository $bonDeCommandeRepository): Response
    {
        return $this->render('bon_de_commande/indexb.html.twig', [
            'bon_de_commande' => $bonDeCommandeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bon_de_commande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CoreSecurity $security, MailerInterface $mailer): Response
    {
        $bonDeCommande = new BonDeCommande();
        $form = $this->createForm(BonDeCommandeType::class, $bonDeCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bonDeCommande->setUser($security->getUser());

            $produit = $bonDeCommande->getProduit();
            if ($produit) {
                $nouvelleQuantite = $produit->getQte() - $bonDeCommande->getQuantite();
                $produit->setQte($nouvelleQuantite);

                // Vérifier si le stock est faible
                if ($nouvelleQuantite <= 1) {
                    $this->envoyerAlerteStockFaible($produit, $mailer);
                }

                $entityManager->persist($produit);
            }

            $entityManager->persist($bonDeCommande);
            $entityManager->flush();

            return $this->redirectToRoute('app_bon_de_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bon_de_commande/new.html.twig', [
            'bon_de_commande' => $bonDeCommande,
            'form' => $form,
        ]);
    }

    private function envoyerAlerteStockFaible(Produit $produit, MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('ahmedbettaib56@gmail.com')
            ->to('ahmedbettaib56@gmail.com')
            ->subject('Alerte: Stock faible')
            ->text(sprintf('Le produit "%s" est presque épuisé. Il ne reste plus que %d en stock.', $produit->getNom(), $produit->getQte()));

        $mailer->send($email);
    }

    #[Route('/{id}', name: 'app_bon_de_commande_show', methods: ['GET'])]
    public function show(BonDeCommande $bonDeCommande): Response
    {
        return $this->render('bon_de_commande/show.html.twig', [
            'bon_de_commande' => $bonDeCommande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bon_de_commande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BonDeCommande $bonDeCommande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BonDeCommandeType::class, $bonDeCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_bon_de_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bon_de_commande/edit.html.twig', [
            'bon_de_commande' => $bonDeCommande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bon_de_commande_delete', methods: ['POST'])]
    public function delete(Request $request, BonDeCommande $bonDeCommande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bonDeCommande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bonDeCommande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bon_de_commande_index', [], Response::HTTP_SEE_OTHER);
    }
}
