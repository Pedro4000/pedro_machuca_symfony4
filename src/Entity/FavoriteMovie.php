<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\FavoriteMovieRepository")
 */
class FavoriteMovie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $theMovieDbId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="products")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTheMovieDbId(): ?int
    {
        return $this->theMovieDbId;
    }

    public function setTheMovieDbId(?int $theMovieDbId): self
    {
        $this->theMovieDbId = $theMovieDbId;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
