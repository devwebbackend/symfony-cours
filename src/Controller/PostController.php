<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route('/post', name: 'post.')]
class PostController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }
    #[Route('/create', name: 'create')]
    public function create(EntityManagerInterface $entityManager,  Request $request): Response
    {
        //$title = "first title";

        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
      
        $form->handleRequest($request);
        $form->getErrors();
       if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($post);
             $entityManager->flush();
       }
     $file =  $request->files->get('attachment');
     if($file){
       $fileName = md5(uniqid()).''.$file->guessClientExtenition(); 
      $file->move(
        $this->getParameter('uploads_dir'),
$fileName
      );
      $post->setImage($fileName);
     }
       // $post->setTitle('first title');

        // $em = $this->getDoctrine()->getManager();

      //  $entityManager->persist($post);

       // $entityManager->flush();
        return $this->render('post/create.html.twig', ['form' =>$form]);
    }


   /*  public function create(EntityManagerInterface $entityManager): Response
    {
       $title= "first title";
       $post = new Post();
  $post->setTitle('first title');

 // $em = $this->getDoctrine()->getManager();

        $entityManager->persist($post);

        $entityManager->flush();
        return $this->render('post/create.html.twig',['title'=>$title]);
    } */
    #[Route('/edit/{id}', name: 'update')]
    public function update(EntityManagerInterface $entityManager, int $id): Response
    {
        $post = $entityManager->getRepository(Post::class)->find($id);
        if( !$post){
          throw $this->createNotFoundException('post not found');

        }
         $post->setTitle('update title');
        $entityManager->persist($post);
        $entityManager->flush();
        return $this->redirect($this->generateUrl('post.index'));
    }
    #[Route('/{post}', name: 'show')]
  /*   public function show(Post $post): Response
    {
        
        return $this->render('post/show.html.twig', ['post'=>$post]);
    } */
  /*    #[Route('/{id}', name: 'show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
     $post =   $entityManager->getRepository(Post::class)->find($id);

if (!$post) {
    throw $this->createNotFoundException(
        'No product found for id ' . $id
    );
}
            $this->addFlash('success', 'title is ');
        return $this->render('post/show.html.twig', ['post' => $post]);
    } 
 
  */
  #[Route('/{id}', name: 'show')]
  public function show(PostRepository $postRepository, int $id): Response
  {
    $post =   $postRepository->findByCategory($id);

    if (!$post) {
      throw $this->createNotFoundException(
        'No product found for id ' . $id
      );
    }
    $this->addFlash('success', 'title is ');
    return $this->render('post/show.html.twig', ['post' => $post]);
  } 
 
 
 
    #[Route('/delete/{id}', name:'delete')]
    public function remove(EntityManagerInterface $entityManager, int $id) {
      $post = $entityManager->getRepository(Post::class)->find($id);
      if(!$post){
        throw $this->createNotFoundexception('post not found');
      }
        $entityManager->remove($post);
      $entityManager->flush();
      $this->addFlash('success', 'deleted successfully');
    return  $this->redirect($this->generateUrl('post.index'));
    }
}
