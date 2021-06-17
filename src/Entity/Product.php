<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"show_detail_product","show_list_products"})
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"show_detail_product","show_list_products"})
     */
    private ?string $Product;

    /**
     * @ORM\Column(type="text")
     * @Groups({"show_detail_product"})
     */
    private ?string $description;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"show_detail_product","show_list_products"})
     */
    private ?int $stock;

    /**
     * @ORM\Column(type="float")
     * @Groups({"show_detail_product","show_list_products"})
     */
    private ?float $price;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"show_detail_product","show_list_products"})
     */
    private ?string $brand;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"show_detail_product"})
     */
    private ?string $color;

    /**
     * @ORM\Column(type="string", length=10)
     * @Groups({"show_detail_product"})
     */
    private ?string $reference;

    /**
     * @ORM\Column(type="date")
     * @Groups({"show_detail_product"})
     */
    private ?\DateTimeInterface $releaseDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?string
    {
        return $this->Product;
    }

    public function setProduct(string $Product): self
    {
        $this->Product = $Product;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }
}
