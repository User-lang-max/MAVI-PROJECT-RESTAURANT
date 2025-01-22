<?php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        // Gestion de l'inscription
        if ($request->request->get('action') === 'signup') {
            $username = $request->request->get('username');
            $password = $request->request->get('password');
            $role = $request->request->get('role');

            if ($username && $password && $role) {
                $user = new User();
                $user->setUsername($username);
                $user->setPassword($password); // Pas de hachage de mot de passe
                $user->setRole($role);

                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'Inscription réussie !');
            } else {
                $this->addFlash('error', 'Tous les champs sont requis.');
            }
        }

        // Gestion de la connexion
        if ($request->request->get('action') === 'login') {
            $username = $request->request->get('username');
            $password = $request->request->get('password');

            $user = $em->getRepository(User::class)->findOneBy(['username' => $username]);

            if ($user && $user->getPassword() === $password) { // Pas de vérification de mot de passe haché
                $this->addFlash('success', 'Connexion réussie !');

                return $this->redirectToRoute($user->getRole() === 'admin' ? 'admin_dashboard' : 'user_dashboard');
            } else {
                $this->addFlash('error', 'Identifiants incorrects.');
            }
        }

        return $this->render('login.html.twig');
    }

    #[Route('/admin', name: 'admin_dashboard')]
    public function adminDashboard(): Response
    {
        return $this->render('admin.html.twig');
    }

    #[Route('/restau', name: 'user_dashboard')]
    public function userDashboard(): Response
    {
        return $this->render('restau.html.twig');
    }

    private function calculateTotalClients(): int
{
    $clients = $this->entityManager->getRepository(Client::class)->findAll();
    return count($clients);
}

}
