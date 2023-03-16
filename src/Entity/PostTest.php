<?php

namespace App\Entity;

use App\Entity\Post;
use App\Entity\Author;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
  public function testSetTitle()
  {
    $post = new Post();
    $post->setTitle('Title');
    $this->assertSame('Title', $post->getTitle());
  }

  public function testSetContent()
  {
    $post = new Post();
    $post->setContent('Content');
    $this->assertSame('Content', $post->getContent());
  }


  public function testAddAuthor()
  {
    $post = new Post();
    $author = new Author();

    $post->addAuthor($author);

    $this->assertTrue($post->getAuthor()->contains($author));
    $this->assertTrue($author->getPosts()->contains($post));
  }

  public function testDeleteAuthor()
  {
    $post = new Post();
    $author = new Author();

    $post->addAuthor($author);
    $post->removeAuthor($author);

    $this->assertFalse($post->getAuthor()->contains($author));
    $this->assertFalse($author->getPosts()->contains($post));
  }
}
