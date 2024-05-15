<?php

namespace Src\Http\Contact;

use Doctrine\ORM\EntityManager;
use Src\Entity\Message;
use Src\Http\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    public function __invoke(Request $request, EntityManager $entityManager): Response
    {
        $form = new ContactForm($request->request);

        if ($form->isValid()) {
            $message = new Message();
            $message->setName($form->get('name')->getData())
                ->setEmail($form->get('email')->getData())
                ->setMessage($form->get('message')->getData());

            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirect('/contact');
        }

        return $this->redirect('/contact', $form->getErrors());
    }
}