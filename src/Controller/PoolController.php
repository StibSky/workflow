<?php

namespace App\Controller;

use App\Entity\Tickets;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class PoolController extends AbstractController
{
    /**
     * @Route("/first", name="first")
     */
    public function index(UserInterface $user){
        $repo = $this->getDoctrine()->getRepository(Tickets::class);
        $user = $this->getUser();
        if ($user->getRoles() === ['ROLE_FIRST_LINE', 'ROLE_USER']) {
            $tickets = $repo->findByLine(1);
        }
        else {
            $tickets = $repo->findByLine(2);
            var_dump($tickets);
        }

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
        ]);
    }

    /**
     * @Route("/agentdash", name="agentDash")
     */
    public function dashboard(UserInterface $user) {
        $em = $this->getDoctrine()->getManager()->getRepository(Tickets::class);
        $tickets = $em->findAssignedToMe($this->getUser()->getId());
        $name = $this->getUser()->getName();

            if (isset($_POST['escalate'])) {
                $ticket = $em->findByTicketId($_POST['escalate']);
                $emAss = $this->getDoctrine()->getManager();
                $ticket->setAssignee(null);
                $ticket->setLine(2);
                $ticket->setStatus(0);
                $emAss->persist($ticket);
                $emAss->flush();
            }

        return $this->render('first/firstdash.html.twig', [
            'tickets' => $tickets,
            'name' => $name
        ]);
    }
}
