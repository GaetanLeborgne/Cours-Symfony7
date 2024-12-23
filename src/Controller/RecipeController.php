<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends AbstractController
{
    #[Route('/recettes', name: 'recipe.index')]
    
    public function index(Request $request, RecipeRepository $repository, EntityManagerInterface $em): Response
    {
        
        $recipes = $repository->findWithDurationLowerThan(20);
        return $this->render('recipe/index.html.twig', [
            'recipes' =>$recipes,
        ]);
    }
    
    #[Route('/recettes/{slug}-{id}', name: 'recipe.show', requirements: ['id' =>'\d+', 'slug' =>'[a-z0-9-]+'])]
    public function show(Request $request, string $slug, int $id, RecipeRepository $recipeRepository): Response
    {
        $recipe = $recipeRepository->find($id);
        if ($recipe->getSlug()!== $slug) {
            return $this->redirectToRoute('recipe.show',['slug' =>$recipe->getSlug(), 'id' =>$recipe->getId()]);
        }
  
        return $this->render('recipe/show.html.twig',[
            'recipe' =>$recipe,
        ]);
    } 

    #[Route('/recettes/{id}/edit', name: 'recipe.edit')]
    public function edit (Recipe $recipe, Request $request,  EntityManagerInterface $em){
        $form = $this ->createForm(RecipeType::class, $recipe);
        $form ->handleRequest($request);
        if ($form ->isSubmitted() && $form->isValid()) {
            $em ->flush();
            $this->addFlash('success', 'la recette a bien était modifier');
            return $this ->redirectToRoute('recipe.index');
        }
        return $this ->render('recipe/edit.html.twig', [
            'recipe' =>$recipe,
            'form' =>$form,
         
        ]);

    }

    #[Route('recettes/create', name:'recipe.create')]
    public function create(Request $request, EntityManagerInterface $em)
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form ->handleRequest($request);
        if ($form ->isSubmitted() && $form->isValid()) {
            $em ->persist($recipe);
            $em->flush();
            $this->addFlash('success', 'la recette a bien était créée');
            return $this ->redirectToRoute('recipe.index');
    }
        return $this ->render('recipe/create.html.twig', [
            'form' =>$form,
        ]);
    }

    #[Route('/recettes/{id}', name: 'recipe.delete', methods: ['DELETE'])]
    public function delete(Recipe $recipe, EntityManagerInterface $em)
    {
        $em->remove($recipe);
        $em->flush();
        $this->addFlash('success', 'La recette a été supprimée avec succès.');
        return $this->redirectToRoute('recipe.index');
    }

}
