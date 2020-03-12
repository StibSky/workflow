<?php

namespace App\Controller;


use App\Entity\Tickets;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ManagerController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(){
        $allTickets = $this->getDoctrine()->getManager()->getRepository('App\Entity\Tickets');
        $tickets = $allTickets->findAll();

        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Tickets::class);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['assign'])) {
                /** @var Tickets $ticket */
                $ticket = $repo->find($_POST['assign']);

                //@todo: check if Ticket is NULL

                $user = null;

                if (isset($_POST['assignfield'])){
                    $user = $this->getDoctrine()->getRepository(User::class)->find($_POST['assignfield']);
                }

                $ticket->setAssignee($user);
                $ticket->setStatus(1);
                $em->flush();
            }
            elseif (isset($_POST['noFix'])) {
                /** @var Tickets $ticket */
                $ticket = $repo->find($_POST['noFix']);
                $ticket->setAssignee(null);
                $ticket->setStatus(5);
                $em->flush();
                //todo send mail + comment
            }

        }

        return $this->render('manager/index.html.twig', [
            'controller_name' => 'ManagerController',
            'tickets' => $tickets
        ]);
    }
}
