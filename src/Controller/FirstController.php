<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    /**
     * @Route("/first", name="first")
     */
    public function index(){
        $allTickets = $this->getDoctrine()->getManager()->getRepository('App\Entity\Tickets');
        $tickets = $allTickets->findAll();

        return $this->render('first/index.html.twig', [
            'controller_name' => 'FirstController',
            'tickets' => $tickets
        ]);
    }
}
