<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {

    $author = new Author();
    $author->setName('Author First');
    $manager->persist($author);

    $author2 = new Author();
    $author2->setName('Author Second');
    $manager->persist($author2);

    $author3= new Author();
    $author3->setName('Author Third');
    $manager->persist($author3);

    $author4 = new Author();
    $author4->setName('Author Fourth');
    $manager->persist($author4);

    $author5 = new Author();
    $author5->setName('Author Fifth');
    $manager->persist($author5);

    $manager->flush();

    $this->addReference('author_1', $author);
    $this->addReference('author_2', $author2);
    $this->addReference('author_3', $author3);
    $this->addReference('author_4', $author4);
    $this->addReference('author_5', $author5);
  }
}
