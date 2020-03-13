<?php

namespace App\Controller;

use App\Entity\TicketComments;
use App\Entity\Tickets;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        elseif ($user->getRoles() === ['ROLE_SECOND_LINE', 'ROLE_USER']) {
            $tickets = $repo->findByLine(2);
        } else {
            $tickets = $repo->findByLine(3);
        }



        $em = $this->getDoctrine()->getManager();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['assign'])) {
                $ticket = $repo->findByTicketId($_POST['assign']);
                $ticket->setAssignee($this->getUser());
                // TODO: Magic number, status would be better as actual constants ('In progress', "open', etc.)
                $ticket->setStatus(1);
                $em->flush();
                header("Refresh:0");
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
    public function dashboard(UserInterface $user, Request $request) {

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

        $repo = $this->getDoctrine()->getRepository(Tickets::class);
        $em = $this->getDoctrine()->getManager();

        $tickets = $repo->findAssignedToMe($this->getUser()->getId());
        $name = $this->getUser()->getName();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['drop'])) {
               $ticket = $repo->findByTicketId($_POST['drop']);
               $ticket->setAssignee(null);
               $ticket->setStatus(0);
               $em->flush();
                header("Refresh:0");
            }
            if (isset($_POST['comment'])) {
                $comment = new TicketComments();
                $comment->setUser($this->getUser());
                $comment->setTicket($repo->findByTicketId($_POST['comment']));
                $comment->setComment($_POST['commentText']);
                $comment->setIsPrivate($_POST['private']);
                $em->persist($comment);
                $em->flush();
            }
        }





        return $this->render('first/firstdash.html.twig', [
            'tickets' => $tickets,
            'name' => $name
        ]);
    }

    public function logout()
    {
        throw new \Exception('Will be intercepted before getting here');
    }
}
