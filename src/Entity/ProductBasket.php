<?php

namespace App\Entity;

use App\Repository\ProductBasketRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductBasketRepository::class)
 */
class ProductBasket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bName;

    /**
     * @ORM\Column(type="integer")
     */
    private $bPrice;

    /**
     * @ORM\Column(type="datetime")
     */
    private $bDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBName(): ?string
    {
        return $this->bName;
    }

    public function setBName(string $bName): self
    {
        $this->bName = $bName;

        return $this;
    }

    public function getBPrice(): ?int
    {
        return $this->bPrice;
    }

    public function setBPrice(int $bPrice): self
    {
        $this->bPrice = $bPrice;

        return $this;
    }

    public function getBDate(): ?\DateTimeInterface
    {
        return $this->bDate;
    }

    public function setBDate(\DateTimeInterface $bDate): self
    {
        $this->bDate = $bDate;

        return $this;
    }

    public function getBUser(): ?string
    {
        return $this->bUser;
    }

    public function setBUser(string $bUser): self
    {
        $this->bUser = $bUser;

        return $this;
    }
}
