<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 * @UniqueEntity(fields={"username"}, message="Ce pseudo est déjà utilisé")
 * @OA\Schema()
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"customer"})
     * @OA\Property(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "Le pseudo ne peut pas faire moins de {{ limit }} caractères",
     *      maxMessage = "Le pseudo ne peut pas faire plus de {{ limit }} caractères"
     * )
     * @Groups({"customer"})
     * @OA\Property(type="string")
     */
    private ?string $username;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\Length(
     *      min = 5,
     *      max = 150,
     *      minMessage = "L'email ne peut pas faire moins de {{ limit }} caractères",
     *      maxMessage = "L'email ne peut pas faire plus de {{ limit }} caractères"
     * )
     * @Assert\Email(
     *     message = "The email {{ value }} is not a valid email."
     * )
     * @OA\Property(type="string")
     * @Groups({"customer"})
     */
    private ?string $email;

    /**
     * @ORM\Column(type="string", length=20)
     * @OA\Property(type="string")
     * @Assert\Regex(
     *     pattern="/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/",
     *     message="Phone format is incorrect."
     * )
     * @Groups({"customer"})
     */
    private ?string $telephone;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="customers")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"customer"})
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
