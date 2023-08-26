<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[route('todo')]
class TodoController extends AbstractController
{
    /**
     * @route("/", name="todo.index")
     */
    #[Route('/', name: 'todo.index')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        $todos= ['achat' => 'cle usb', 'dimanche' => 'cour symfony'];
if(!$session->has('todo')) {
    $session->set('todo', $todos);

}
$this->addFlash('succes', "la liste de todo");
        return $this->render('todo/index.html.twig');
       
    }

    #[route('/add/{name?test}/{content?test}', name:'add.todo')]
    public function addTodo(Request $request, $name, $content){
        $session =$request->getSession('todo');
         if($session->has('todo')){
            $todos = $session->get('todo');
           // array_push($todos, [$name => $content]);
           $todos[$name] = $content;
            $session->set('todo', $todos);
            $this->addFlash('success',"la list $name ajout avec success");
        } else {
          /*   $todos[$name] = $content;
            $session->set('todo', $todos); */
            $this->addFlash('error',"la list $name n'est exixt pas");
        } 
        return $this->redirectToRoute('todo.index');
    }
}
