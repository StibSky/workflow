<?php

namespace App\Controller;

use App\Entity\Tickets;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PoolController extends AbstractController
{
    /**
     * @Route("/first", name="first")
     */
    public function index(){
        //$tickets = $allTickets->findAll();
            var_dump($this->getUser());
        $repo = $this->getDoctrine()->getRepository(Tickets::class);
        $myTickets = $repo->findByAssigneeId($this->getUser());
        $tickets = $repo->findByNull();


        $em = $this->getDoctrine()->getManager();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['assign'])) {

                $ticket = $repo->findByTicketId($_POST['assign']);
                $ticket->setAssignee($this->getUser());
                $ticket->setStatus(1);
                $em->flush();
            }
        }

        return $this->render('first/index.html.twig', [
            'controller_name' => 'PoolController',
            'tickets' => $tickets,
            'my_tickets' => $myTickets
        ]);
    }
}
