<?php

namespace App\Controller;

use App\DTO\ContactDTO;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request): Response
    {
        $data = new ContactDTO();

        // TODO : A SUPPREMER A LA FIN DE LA FASE DE TEST
        $data->name = 'John Doe';
        $data->email = 'john';
        $data->message = 'supersite';


        $form = $this->createForm(ContactType::class, $data);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Envoyer email
        }
        return $this->render('contact/contact.html.twig', [
            'form' => $form,
        ]);
    }
}
