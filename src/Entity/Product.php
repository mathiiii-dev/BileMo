<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use OpenApi\Annotations as OA;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @OA\Schema()
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "api_get_product",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups={"show_detail_product","show_list_products"})
 * )
 * @Hateoas\Relation(
 *      "get_products",
 *      href = @Hateoas\Route(
 *          "api_get_products",
 *          parameters = { "page" = "1" },
 *          absolute = true
 *      ),
 *     exclusion = @Hateoas\Exclusion(groups={"show_detail_product","show_list_products"})
 * )
 * @Serializer\ExclusionPolicy("all")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"show_detail_product","show_list_products"})
     * @OA\Property(type="integer")
     * @Serializer\Expose
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Serializer\Groups({"show_detail_product","show_list_products"})
     * @OA\Property(type="string")
     * @Serializer\Expose
     */
    private ?string $Product;

    /**
     * @ORM\Column(type="text")
     * @Serializer\Groups({"show_detail_product"})
     * @OA\Property(type="string")
     * @Serializer\Expose
     */
    private ?string $description;

    /**
     * @ORM\Column(type="integer")
     * @OA\Property(type="integer")
     * @Serializer\Groups({"show_detail_product","show_list_products"})
     * @Serializer\Expose
     */
    private ?int $stock;

    /**
     * @ORM\Column(type="float")
     * @OA\Property(type="number")
     * @Serializer\Groups({"show_detail_product","show_list_products"})
     * @Serializer\Expose
     */
    private ?float $price;

    /**
     * @ORM\Column(type="string", length=50)
     * @OA\Property(type="string")
     * @Serializer\Groups({"show_detail_product","show_list_products"})
     * @Serializer\Expose
     */
    private ?string $brand;

    /**
     * @ORM\Column(type="string", length=50)
     * @OA\Property(type="string")
     * @Serializer\Groups({"show_detail_product"})
     * @Serializer\Expose
     */
    private ?string $color;

    /**
     * @ORM\Column(type="string", length=10)
     * @OA\Property(type="string")
     * @Serializer\Groups({"show_detail_product"})
     * @Serializer\Expose
     */
    private ?string $reference;

    /**
     * @ORM\Column(type="date")
     * @OA\Property(type="string", format="date-time")
     * @Serializer\Groups({"show_detail_product"})
     * @Serializer\Expose
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
