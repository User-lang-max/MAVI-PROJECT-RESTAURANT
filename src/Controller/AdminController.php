<?php
namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\ReservationEnCours;
use App\Entity\Orders;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin', name: 'admin_index')]
    public function index(): Response
    {
        // Récupérer toutes les réservations depuis la base de données
        $reservations = $this->entityManager->getRepository(Reservation::class)->findAll();

        // Calculer le total des réservations
        $totalReservations = count($reservations); // Compter le nombre total de réservations
        $totalOrders = $this->calculateTotalOrders();
        $totalClients = $this->calculateTotalClients();

        // Préparer les données pour les graphiques
        $reservationsByHour = $this->getReservationsByHour($reservations);
        $reservationsByDay = $this->getReservationsByDay($reservations);

        // Passer les données des réservations et des graphiques à la vue
        return $this->render('admin/admin.html.twig', [
            'reservations' => $reservations,
            'totalReservations' => $totalReservations,  // Passer le total à la vue
            'totalOrders' => $totalOrders,
        'totalClients' => $totalClients,
            'reservationsByHour' => json_encode($reservationsByHour),
            'reservationsByDay' => json_encode($reservationsByDay)
        ]);
    }

    #[Route('/admin/add', name: 'add_reservation', methods: ['POST'])]
    public function add(Request $request): Response
    {
        
        $reservation = new Reservation();
        $reservation->setNomComplet($request->get('nom_complet'))
                    ->setEmail($request->get('email'))
                    ->setTelephone($request->get('telephone'))
                    ->setHeure(new \DateTime($request->get('heure')))
                    ->setGuests((int)$request->get('guests')) 
                    ->setDate(new \DateTime($request->get('date')));

        $this->entityManager->persist($reservation);
        $this->entityManager->flush();

        return $this->redirectToRoute('admin_index');
    }

    #[Route('/admin/edit/{id}', name: 'edit_reservation', methods: ['POST'])]
public function edit(Request $request, Reservation $reservation): Response
{
    $reservation = $this->entityManager->getRepository(Reservation::class)->find($id);

    if (!$reservation) {
        throw $this->createNotFoundException('Réservation non trouvée');
    }

    $reservation->setNomComplet($request->get('nom_complet'))
                ->setEmail($request->get('email', $reservation->getEmail()))
                ->setTelephone($request->get('telephone', $reservation->getTelephone()))
                ->setHeure(new \DateTime($request->get('heure', $reservation->getHeure()->format('H:i'))))
                ->setGuests((int)$request->get('guests', $reservation->getGuests())) 
                ->setDate(new \DateTime($request->get('date', $reservation->getDate()->format('Y-m-d')))); 

    $this->entityManager->flush();

    return $this->redirectToRoute('admin_index');
}


    #[Route('/admin/delete/{id}', name: 'delete_reservation')]
    public function delete($id): Response
    {
        $reservation = $this->entityManager->getRepository(Reservation::class)->find($id);

        if (!$reservation) {
            throw $this->createNotFoundException('Réservation non trouvée');
        }

        $this->entityManager->remove($reservation);
        $this->entityManager->flush();

        return $this->redirectToRoute('admin_index');
    }

    // Fonction pour récupérer les réservations par heure
    private function getReservationsByHour($reservations)
    {
        $counts = [];
        foreach ($reservations as $reservation) {
            $hour = $reservation->getHeure()->format('H');  // Récupérer l'heure sous format 'H'
            $counts[$hour] = isset($counts[$hour]) ? $counts[$hour] + 1 : 1;
        }

        $labels = array_keys($counts);
        $values = array_values($counts);

        return ['labels' => $labels, 'values' => $values];
    }

    // Fonction pour récupérer les réservations par jour
    private function getReservationsByDay($reservations)
    {
        $counts = [];
        foreach ($reservations as $reservation) {
            $date = $reservation->getHeure()->format('Y-m-d');  // Récupérer la date sous format 'YYYY-MM-DD'
            $counts[$date] = isset($counts[$date]) ? $counts[$date] + 1 : 1;
        }

        $labels = array_keys($counts);
        $values = array_values($counts);

        return ['labels' => $labels, 'values' => $values];
    }

    private function calculateTotalOrders(): int
    {
        $orders = $this->entityManager->getRepository(Orders::class)->findAll();
        return count($orders);
    }
    
    private function calculateTotalClients(): int
    {
        $clients = $this->entityManager->getRepository(User::class)->findAll();
        return count($clients);
    }

    #[Route('/reservation/add', name: 'reservation_added', methods: ['POST'])]
    public function addReservation(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupération des données depuis la requête
        $name = $request->request->get('name'); // Correction du nom de la variable
        $email = $request->request->get('email');
        $phone = $request->request->get('phone');
        $date = $request->request->get('date');
        $time = $request->request->get('time');
        $guests = $request->request->get('guests');
      
    
        // Validation des données
        if (empty($name) || empty($email) || empty($phone) || empty($date) || empty($time) || empty($guests)) {
            return $this->json([
                'error' => 'Tous les champs (name, email, phone, date, time, guests) sont requis.',
            ], Response::HTTP_BAD_REQUEST);
        }
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->json([
                'error' => 'L\'adresse e-mail n\'est pas valide.',
            ], Response::HTTP_BAD_REQUEST);
        }
    
        if (!is_numeric($guests) || (int)$guests <= 0) {
            return $this->json([
                'error' => 'Le nombre de personnes (guests) doit être un entier positif.',
            ], Response::HTTP_BAD_REQUEST);
        }
    
        try {
            // Création d'une nouvelle instance de la réservation
            $reservation = new ReservationEnCours();
            $reservation->setName($name);
            $reservation->setEmail($email);
            $reservation->setPhone($phone);
    
            // Conversion et validation des formats de date et heure
            try {
                $reservation->setDate(new \DateTime($date)); // Conversion de la date
                $reservation->setTime(new \DateTime($time)); // Conversion de l'heure
            } catch (\Exception $e) {
                return $this->json([
                    'error' => 'Le format de la date ou de l\'heure est invalide. Utilisez le format YYYY-MM-DD pour la date et HH:MM:SS pour l\'heure.',
                ], Response::HTTP_BAD_REQUEST);
            }
    
            $reservation->setGuests((int)$guests);
            
    
            // Sauvegarde dans la base de données
            $entityManager->persist($reservation);
            $entityManager->flush();
    
            // Réponse JSON
            return $this->json([
                'message' => 'Réservation ajoutée avec succès.',
                'data' => [
                    'id' => $reservation->getId(),
                    'name' => $reservation->getName(),
                    'email' => $reservation->getEmail(),
                    'phone' => $reservation->getPhone(),
                    'date' => $reservation->getDate()->format('Y-m-d'),
                    'time' => $reservation->getTime()->format('H:i:s'),
                    'guests' => $reservation->getGuests(),
                ],
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // Gestion des erreurs
            return $this->json([
                'error' => 'Une erreur s\'est produite lors de l\'ajout de la réservation : ' . $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    

    
    
}
