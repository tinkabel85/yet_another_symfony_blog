<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends AbstractController
{
  // #[Route('/blog', name: 'blog_list')]
  public function list(PostRepository $postRepository): Response
  {
    return $this->render('post/index.twig', ['posts' => $postRepository->findAll()]);
  }

  public function createPost(Request $request, EntityManagerInterface $entityManager): Response
  {
    $post = new Post();
    // $post->setTitle('Title');
    // $post->setContent('This is a new post');

    $form = $this->createForm(PostType::class, $post);

    $form = $this->createFormBuilder($post)
      ->add('title', TextType::class)
      ->add('content', TextareaType::class)
      ->add('save', SubmitType::class, [
        'label' => 'Create Post', 'attr' => [
          'class' => 'btn btn-outline-success',
        ],
      ],)
      ->getForm();

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $post = $form->getData();
      $entityManager->persist($post);
      $entityManager->flush();
      $this->addFlash('success', 'Post was created!');
      return $this->redirectToRoute('blog_list');
    }


    return $this->render('post/create.twig', [
      'form' => $form->createView(),
    ]);
  }

  public function deletePost(Post $post, EntityManagerInterface $entityManager): RedirectResponse
  {
    $entityManager->remove($post);
    $entityManager->flush();
    $this->addFlash('success', 'Blog was edited!');

    return $this->redirectToRoute('blog_list');
  }

  public function editPost(Post $post, EntityManagerInterface $entityManager, Request $request)
  {
    $form = $this->createForm(PostType::class, $post);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $post = $form->getData();
      $entityManager->persist($post);
      $entityManager->flush();
      $this->addFlash('success', 'Post was edited!');
      return $this->redirectToRoute('blog_list');
    }

    return $this->render('post/create.twig', [
      'form' => $form->createView(),
    ]);
  }

  public function showPost(Post $post = null): Response
  {
    if (!$post) {
      throw $this->createNotFoundException('The post does not exist');
    }
    return $this->render('post/show.twig', ['post' => $post]);
  }
}
