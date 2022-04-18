<?php

namespace App\Entity;

use App\Repository\WpisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WpisRepository::class)
 * @ORM\Table(name="wpisy")
 */
class Wpis
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $zdjecie;

    /**
     * @ORM\ManyToOne(targetEntity=Trasa::class)
     */
    private $trasa;

    /**
     * Author.
     *
     * @var User|null
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getZdjecie(): ?string
    {
        return $this->zdjecie;
    }

    public function setZdjecie(?string $zdjecie): self
    {
        $this->zdjecie = $zdjecie;

        return $this;
    }

    public function getTrasa(): ?Trasa
    {
        return $this->trasa;
    }

    public function setTrasa(?Trasa $trasa): self
    {
        $this->trasa = $trasa;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
