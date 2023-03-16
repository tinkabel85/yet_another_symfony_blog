<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  private ?string $title = null;

  #[ORM\Column(type: Types::TEXT)]
  private ?string $content = null;

  #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'posts')]
  private Collection $author;

  public function __construct()
  {
    $this->author = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getTitle(): ?string
  {
    return $this->title;
  }

  public function setTitle(string $title): self
  {
    $this->title = $title;

    return $this;
  }

  public function getContent(): ?string
  {
    return $this->content;
  }

  public function setContent(string $content): self
  {
    $this->content = $content;

    return $this;
  }

  /**
   * @return Collection<int, Author>
   */
  public function getAuthor(): Collection
  {
    return $this->author;
  }

  public function addAuthor(Author $author): self
  {
    if (!$this->author->contains($author)) {
      $this->author->add($author);
      $author->addPost($this);
    }

    return $this;
  }

  public function removeAuthor(Author $author): self
  {
    $this->author->removeElement($author);
    $author->removePost($this);

    return $this;
  }
}
