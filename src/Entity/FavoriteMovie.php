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
    private $the_movie_db_id;

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
        return $this->the_movie_db_id;
    }

    public function setTheMovieDbId(?int $the_movie_db_id): self
    {
        $this->the_movie_db_id = $the_movie_db_id;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUserId(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
