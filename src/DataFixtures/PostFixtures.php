<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {

    $post = new Post();
    $post->setTitle('Introducing the webapp pack');
    $post->setContent('To sum up, when creating a new Symfony project where you know you will use Doctrine, Messenger, Mailer, Notifier, or any "more advanced" feature, the new webapp pack helps you get started faster with a great default configuration. Symfony Flex makes it painless.');
    //add author to pivot table
    $post->addAuthor($this->getReference('author_1'));
    $post->addAuthor($this->getReference('author_2'));

    $manager->persist($post);


    $post1 = new Post();
    $post1->setTitle('About testing stuff...');
    $post1->setContent('Symfony has always advocated for writing automated tests and provided the tools necessary to do so in your project, but support for testing plugins has been limited... until now!.');

    $post1->addAuthor($this->getReference('author_3'));
    $post1->addAuthor($this->getReference('author_5'));

    $manager->persist($post1);

    $post2 = new Post();
    $post2->setTitle('Cross Application Links');
    $post2->setContent('One of the most requested feature for symfony is the ability to create links to a frontend application from a backend one. This post shows how it can be done very easily with symfony 1.2.');

    $post2->addAuthor($this->getReference('author_1'));
    $post2->addAuthor($this->getReference('author_4'));
    
    $manager->persist($post2);

    $post3 = new Post();
    $post3->setTitle('Get started with Symfony ');
    $post3->setContent('How can you get started with Symfony 6? What is the best resources to learn Symfony? How can I learn about the latest best practices? Thats legitimate questions I get from the community.');
    
    $post3->addAuthor($this->getReference('author_4'));

    $manager->persist($post3);

    $manager->flush();
  }
}
