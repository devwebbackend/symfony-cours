<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
if($session->has('nbViste')){
    $visite = $session->get('nbViste') + 1;

} else {
    $visite = 1;
}
        $session->set('nbVisite', $visite);
        return $this->render('session/index.html.twig', [
            'nombre de visite' => $session->get('nbVisite'),
        ]);
    }
}
