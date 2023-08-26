<?php
// src/Controller/TaskController.php
namespace App\Controller;

use PharIo\Manifest\Requirement;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class TaskController extends AbstractController
{

/* #[route('/first/{name}', name:'start')]
public function number(Request $request,$name): Response
{

dd($request);
return $this->render(
 'task/index.html.twig',['name'=>$name]
);
} */
#[route('/multi/{num1<\d+>}/{num2<\d+}',
 name:'multiplication',
 //Requirements:['num1'=> '\d+', 'num2'=> '\d+']
 )]
public function number(Request $request,$num1, $num2): Response
{

    $resultat = $num1 * $num2;

return new response(
 "<h1>$resultat</h1>"
);
}
}