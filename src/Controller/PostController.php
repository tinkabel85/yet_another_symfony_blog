<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends AbstractController
{
  private EntityManagerInterface $entityManager;
  private PostRepository $postRepository;

  public function __construct(EntityManagerInterface $entityManager, PostRepository $postRepository)
  {
    $this->entityManager = $entityManager;
    $this->postRepository = $postRepository;
  }

  public function list(): Response
  {
    $repository = $this->entityManager->getRepository(Post::class);
    $posts = $repository->findAll();
    //dd($posts);
    // return $this->render('post/index.twig', ['posts' => $this->postRepository->findAll()]);
    return $this->render('post/index.twig', ['posts' => $posts]);
  }

  public function createPost(Request $request): Response
  {
    $post = new Post();

    $form = $this->createForm(PostType::class, $post);

    $form = $this->createFormBuilder($post)
      ->add('title', TextType::class)
      ->add('content', TextareaType::class)
      ->add('save', SubmitType::class, [
        'label' => 'Create Post',
        'attr' => [
          'class' => 'btn btn-outline-success',
        ],
      ],)
      ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $post = $form->getData();
      $this->entityManager->persist($post);
      $this->entityManager->flush();
      $this->addFlash('success', 'Post was created!');

      return $this->redirectToRoute('blog_list');
    }

    return $this->render('post/create.twig', [
      'form' => $form->createView(),
    ]);
  }

  public function deletePost(Post $post): RedirectResponse
  {
    $this->entityManager->remove($post);
    $this->entityManager->flush();
    $this->addFlash('success', 'Blog was edited!');

    return $this->redirectToRoute('blog_list');
  }

  public function editPost(Post $post, Request $request)
  {
    $form = $this->createForm(PostType::class, $post);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $post = $form->getData();
      $this->entityManager->persist($post);
      $this->entityManager->flush();
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