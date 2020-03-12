<?php

namespace App\Controller;

use App\Entity\Tickets;
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

/*        if ($user->getRoles() === ['ROLE_CUSTOMER', 'ROLE_USER']) {
            $text = "cool";
        } else {
            $text= "help";
        }*/

        if ($form->isSubmitted() && $form->isValid()) {
            $ticket->setLine(1);
            $ticket->setStatus(0);
            $ticket->setPriority(0);

            $ticket->setCustomer($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ticket);
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

    /**
     * @param UserInterface $user
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("customer/tickets", name="customerTickets")
     */
    public function showTickets(UserInterface $user) {

        $em = $this->getDoctrine()->getRepository(Tickets::class);
        $tickets = $em->findByCustomerId($this->getUser()->getId());


        return $this->render('customer/tickets.html.twig', [
            'tickets' => $tickets
        ]);
    }
}
