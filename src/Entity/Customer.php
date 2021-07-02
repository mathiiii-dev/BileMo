<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use OpenApi\Annotations as OA;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 * @UniqueEntity(fields={"username"}, message="The username already exist")
 * @UniqueEntity(fields={"email"}, message="The email already exist")
 * @OA\Schema()
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "api_get_customer",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *     exclusion = @Hateoas\Exclusion(groups={"customer"})
 * )
 * @Hateoas\Relation(
 *      "get_customers",
 *      href = @Hateoas\Route(
 *          "api_get_customers",
 *          parameters = { "id" = "45", "page" = "1" },
 *          absolute = true
 *      ),
 *     exclusion = @Hateoas\Exclusion(groups={"customer"})
 * )
 * @Hateoas\Relation(
 *      "delete",
 *      href = @Hateoas\Route(
 *          "api_delete_customer",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *    exclusion = @Hateoas\Exclusion(groups={"customer"})
 * )
 * @Hateoas\Relation(
 *      "add",
 *      href = @Hateoas\Route(
 *          "api_add_customer",
 *          absolute = true
 *      ),
 *     exclusion = @Hateoas\Exclusion(groups={"customer"})
 * )
 * @Hateoas\Relation(
 *     "client",
 *     embedded = @Hateoas\Embedded("expr(object.getClient().getId())"),
 *     exclusion = @Hateoas\Exclusion(groups={"customer"})
 * )
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"customer"})
     * @OA\Property(type="integer")
     * @Serializer\Expose
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "The username can't be less than {{ limit }} characters",
     *      maxMessage = "The username can't exced {{ limit }} characters"
     * )
     * @Serializer\Groups({"customer"})
     * @OA\Property(type="string")
     * @Serializer\Expose
     */
    private ?string $username;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\Length(
     *      min = 5,
     *      max = 150,
     *      minMessage = "The mail can't be less than {{ limit }} characters",
     *      maxMessage = "The username can't exced {{ limit }} characters"
     * )
     * @Serializer\Expose
     * @Assert\Email(
     *     message = "The email {{ value }} is not a valid email."
     * )
     * @OA\Property(type="string")
     * @Serializer\Groups({"customer"})
     */
    private ?string $email;

    /**
     * @ORM\Column(type="string", length=20)
     * @OA\Property(type="string")
     * @Serializer\Expose
     * @Assert\Regex(
     *     pattern="/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/",
     *     message="Phone format is incorrect."
     * )
     * @Serializer\Groups({"customer"})
     */
    private ?string $telephone;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="customers")
     * @ORM\JoinColumn(nullable=false)
     * @Serializer\Groups({"customer"})
     * @Serializer\Expose
     * @OA\Property(type="object", ref="#/components/schemas/User")
     */
    private User $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }
}
