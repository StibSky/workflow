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
        $allTickets = $this->getDoctrine()->getManager()->getRepository('App\Entity\Tickets');
        $tickets = $allTickets->findAll();

        $em = $this->getDoctrine()->getManager();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['assign'])) {
                $repo = $this->getDoctrine()->getRepository(Tickets::class);
                $ticket = $repo->findByTicketId($_POST['assign']);
                $ticket->setAssignee($this->getUser());
                $ticket->setStatus(1);
                $em->flush();
            }
        }

        return $this->render('first/index.html.twig', [
            'controller_name' => 'PoolController',
            'tickets' => $tickets
        ]);
    }
}
