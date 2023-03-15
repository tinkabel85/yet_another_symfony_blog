<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    for ($i = 1; $i < 5; $i++) {
      $post = new Post();
      $post->setTitle('Title');
      $post->setContent("Lorem Ipsum is simply dummy text of the
printing and typesetting industry. Lorem Ipsum has been
the industry's standard dummy text ever since the 1500s,
when an unknown printer took a galley of type and scrambled
it to make a type specimen book.");
      $manager->persist($post);
    }

    $manager->flush();
  }
}
