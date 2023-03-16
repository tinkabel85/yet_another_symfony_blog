<?php

namespace App\Entity;

use App\Entity\Author;
use App\Entity\Post;
use PHPUnit\Framework\TestCase;

class AuthorTest extends TestCase
{
  public function testSetName()
  {
    $author = new Author();
    $author->setName('Name');
    $this->assertSame('Name', $author->getName());
  }

  public function testAddPost() {
    $author = new Author();
    $post = new Post();

    $author->addPost($post);
    $this->assertTrue($author->getPosts()->contains($post));
    $this->assertTrue($post->getAuthor()->contains($author));
  }

  public function testRemoveTest() {
    $author = new Author();
    $post = new Post();

    $author->addPost($post);
    $author->removePost($post);

    $this->assertFalse($author->getPosts()->contains($post));
    $this->assertFalse($post->getAuthor()->contains($author));
  }
}
