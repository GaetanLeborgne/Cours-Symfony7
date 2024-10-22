<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController{

    #[Route("/", name: "home")]
    // Cette annotation définit une route pour l'URL racine ("/").
    // Le nom de la route est "home", ce qui permet de l'identifier facilement dans l'application.
    
    function index (Request $request): Response {
        // La méthode "index" accepte un objet "Request" en paramètre, qui représente la requête HTTP reçue par le serveur.
    
        dd($request);
        // La fonction "dd()" (dump and die) est utilisée pour afficher le contenu de la requête et arrêter l'exécution du script,
        // ce qui est utile pour le débogage.
    
        return new Response('Hello ' . $request->query->get('name', 'Inconnu'));
        // Si la fonction "dd()" est supprimée, la méthode renverra une réponse contenant le texte "Hello ".
        // Elle récupère la valeur du paramètre "name" dans la requête GET. Si ce paramètre n'est pas présent, elle renverra "Inconnu" par défaut.
    }
}