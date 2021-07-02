<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations as OA;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"username"}, message="This pseudo is already used")
 * @UniqueEntity(fields={"email"}, message="This email is already used")
 * @OA\Schema()
 * @Serializer\ExclusionPolicy("all")
 */
class User implements UserInterface
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
     * @ORM\Column(type="string", length=50, unique=true)
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "Votre pseudo ne peut pas faire moins de {{ limit }} caractères",
     *      maxMessage = "Votre pseudo ne peut pas faire plus de {{ limit }} caractères"
     * )
     * @Serializer\Expose
     * @Serializer\Groups({"customer"})
     * @OA\Property(type="string")
     * @Assert\NotBlank(message="The field username are missing.")
     */
    private string $username;

    /**
     * @ORM\Column(type="json")
     * @Serializer\Groups({"customer"})
     * @Serializer\Expose
     * @OA\Property(type="object")
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="The field password are missing.")
     */
    private string $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"customer"})
     * @Serializer\Expose
     * @OA\Property(type="string")
     * @Assert\NotBlank(message="The field email are missing.")
     * @Assert\Email(message="This value is not a valid email address.")
     */
    private ?string $email;

    /**
     * @ORM\OneToMany(targetEntity=Customer::class, mappedBy="client")
     */
    private $customers;

    public function __construct()
    {
        $this->customers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    /**
     * @return Collection|Customer[]
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
            $customer->setClient($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        if ($this->customers->removeElement($customer)) {
            // set the owning side to null (unless already changed)
            if ($customer->getClient() === $this) {
                $customer->setClient(null);
            }
        }

        return $this;
    }
}
