<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilterController extends AbstractController
{
    #[Route('/filter/{nbTab<d+>?10}', name: 'app_filter')]
    public function index($nbTab): Response
    {
        for($i=0 ; $i< $nbTab; $i++){
            $notes[$i]= rand(0,20);
        }
        return $this->render('filter/index.html.twig', [
            'notes' => $notes,
        ]);
    }
}
