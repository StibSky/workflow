<?php

namespace App\Controller;

use App\Entity\TicketComments;
use App\Entity\Tickets;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CustomerFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    /**
     * @Route("/customer", name="customer")
     */
    public function index(Request $request)
    {
        $ticket = new Tickets();
        //$comment = new TicketComments();

        $form = $this->createForm(CustomerFormType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticket->setSubject($form->get('subject')->getData());
            //$comment->setComment($form->get('message')->getData());
            $ticket->setLine($form->get('line')->getData());
            $ticket->setStatus($form->get('status')->getData());
            $ticket->setPriority($form->get('priority')->getData());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ticket);
            //$entityManager->persist($comment);
            $entityManager->flush();
        }

        //$em = $this->getDoctrine()->getManager();
/*        if (isset($_POST)) {
            $ticket->setSubject($_POST['subject']);
            $comment->setComment($_POST['message']);
            $ticket->setLine($_POST['line']);
            $ticket->setStatus($_POST['status']);
            $ticket->setPriority($_POST['priority']);

            //$em->persist($ticket);
            //$em->persist($comment);
            //$em->flush();
        }*/

        return $this->render('customer/index.html.twig', [
            'customerForm' => $form->createView(),
        ]);
    }
}
