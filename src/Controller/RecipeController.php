<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends AbstractController
{
    #[Route('/', name: 'recipe.index')]
    // Cette annotation définit une route pour l'URL racine ("/").
    // Le nom de la route est "recipe.index", qui peut être utilisé pour référencer cette route dans l'application.
    
    public function index(Request $request): Response
    {
        // La méthode "index" reçoit une requête HTTP (Request) en paramètre.
        // Ici, elle renvoie simplement une réponse avec le texte "Recette".
        return new Response('Recette');
    }
    
    #[Route('/recette/{slug}-{id}', name: 'recipe.show', requirements: ['id' => '\d+', 'slug' => '[a-z0-9-]+'])]
    // Cette annotation définit une route dynamique pour afficher une recette particulière.
    // Elle accepte deux paramètres : "slug" (qui doit correspondre à un format de chaîne de caractères avec des lettres, chiffres et tirets)
    // et "id" (qui doit être un nombre entier, défini par le requirement '\d+').
    // Le nom de la route est "recipe.show".
    
    public function show(Request $request, string $slug, int $id): Response
    {
        // La méthode "show" reçoit une requête HTTP, ainsi que les paramètres "slug" et "id" extraits de l'URL.
        
        return new JsonResponse([
            'slug' => $slug
        ]);
        // Renvoie une réponse JSON contenant le slug, pour un usage potentiel dans une API ou une interface front-end.
    
        return new Response('Recette : ' . $slug);
        // Cette ligne retourne une réponse HTTP avec le contenu "Recette : " suivi du slug passé dans l'URL.
        // Le slug est extrait de l'URL dynamique (ex. "/recette/mon-slug-123") et permet d'afficher la recette en question.
    }
    
}
