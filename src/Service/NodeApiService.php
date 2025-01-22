<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class NodeApiService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    // Fonction pour récupérer les utilisateurs depuis l'API Node.js
    public function getUsers()
    {
        $response = $this->client->request('GET', 'http://localhost:3000/users');
        return $response->toArray();  // Retourner les utilisateurs sous forme de tableau
    }

    // Fonction pour envoyer de nouvelles données d'utilisateur
    public function addUser($user)
    {
        $response = $this->client->request('POST', 'http://localhost:3000/users', [
            'json' => $user  // Envoyer l'objet JSON
        ]);

        return $response->toArray();  // Retourner la réponse du serveur
    }
}
