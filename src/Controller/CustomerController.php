<?php

namespace App\Controller;

use App\Entity\Tickets;
use App\Entity\TicketComments;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CustomerFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class CustomerController extends AbstractController
{
    /**
     * @Route("/customer", name="customer")
     */
    public function index(Request $request, UserInterface $user)
    {
        $ticket = new Tickets();

        $form = $this->createForm(CustomerFormType::class, $ticket);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $ticket->setCustomer($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ticket);
            $entityManager->flush();
        }

        return $this->render('customer/index.html.twig', [
            'customerForm' => $form->createView(),
        ]);
    }

    /**
     * @param UserInterface $user
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("customer/tickets", name="customerTickets")
     */
    public function showTickets(UserInterface $user) {

        $em = $this->getDoctrine()->getRepository(Tickets::class);
        $tickets = $em->findByCustomerId($this->getUser()->getId());

        $emCom = $this->getDoctrine()->getRepository(TicketComments::class);

        foreach ($tickets as $ticket) {
            $comments = $emCom->findAssociatedWithTicket($ticket->getId());
        }

        return $this->render('customer/tickets.html.twig', [
            'tickets' => $tickets,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('Will be intercepted before getting here');
    }
}
