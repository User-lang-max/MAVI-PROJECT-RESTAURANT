<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\ReservationEnCours;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrderController extends AbstractController
{
    #[Route('/order_form', name: 'order_form', methods: ['POST'])]
    public function createOrder(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupération des données du formulaire
        $fullname = $request->request->get('fullname');
        $email = $request->request->get('email');
        $mealType = $request->request->get('mealType');
        $menuItem = $request->request->get('menuItem');
        $adresse = $request->request->get('address'); // Correspond à "adresse" dans la base de données

        // Validation basique
        if (empty($fullname) || empty($email) || empty($mealType) || empty($menuItem) || empty($adresse)) {
            return new Response('<h1>Erreur : Tous les champs sont obligatoires.</h1>', Response::HTTP_BAD_REQUEST);
        }

        // Création de l'objet Orders
        $order = new Orders();
        $order->setFullname($fullname);
        $order->setEmail($email);
        $order->setMealType($mealType);
        $order->setMenuItem($menuItem);
        $order->setAdresse($adresse);
        

        // Enregistrement dans la base de données
        $entityManager->persist($order);
        $entityManager->flush();

        // Retourner un message de confirmation
        return new Response('<h1>Commande enregistrée avec succès !</h1>', Response::HTTP_OK);
    }

    #[Route('/orders', name: 'orders_list', methods: ['GET'])]
    public function listOrders(EntityManagerInterface $entityManager): Response
    {
        // Récupérer toutes les commandes
        $orders = $entityManager->getRepository(Orders::class)->findAll();

        // Renvoyer à la vue
        return $this->render('commd.html.twig', [
            'orders' => $orders,
        ]);
    }

    #[Route('/orders/delete/{id}', name: 'orders_delete', methods: ['POST'])]
    public function deleteOrder(int $id, EntityManagerInterface $entityManager): Response
    {
        // Récupérer la commande à supprimer
        $order = $entityManager->getRepository(Orders::class)->find($id);

        if ($order) {
            $entityManager->remove($order);
            $entityManager->flush();
        }

        // Rediriger vers la liste des commandes
        return $this->redirectToRoute('orders_list');
    }

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

  
    
       
    
  
    public function getOrdersByCategory(EntityManagerInterface $entityManager): JsonResponse
{
    $query = $entityManager->createQuery(
        'SELECT o.mealType AS category, COUNT(o.id) AS count
         FROM App\Entity\Orders o
         GROUP BY o.mealType'
    );

    $result = $query->getResult();

    return new JsonResponse($result);
    
}

private function calculateTotalOrders(): int
{
    $orders = $this->entityManager->getRepository(Order::class)->findAll();
    return count($orders);
}

}


