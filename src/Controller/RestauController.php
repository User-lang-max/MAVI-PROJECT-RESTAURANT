<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestauController extends AbstractController
{
    #[Route('/restau', name: 'reservation_index')]
    public function index(): Response
    {
        return $this->render('restau.html.twig');
    }

    public function showReservations(Request $request): Response
{
    // Exemple d'obtention des données (adapter selon votre logique et entité)
    $reservations = $this->getDoctrine()->getRepository(ReservationEnCours::class)->findAll();

    return $this->render('commd.html.twig', [
        'reservations' => $reservations,
    ]);
}

}