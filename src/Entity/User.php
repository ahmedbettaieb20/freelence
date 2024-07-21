<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = ["ROLE_USER"];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 15)]
    #[Assert\NotBlank(message:"First Name is required.")]
    private ?string $First_Name = null;

    #[ORM\Column(length: 20)]
    private ?string $Last_Name = null;

    #[ORM\Column(length: 1)]
    private ?string $Gender = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Address = null;

    #[ORM\Column(nullable: true)]
    private ?int $Phone_Number = null;

    #[ORM\Column]
    private ?int $CIN = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $Created_At = null;

    

    #[ORM\Column(length: 255)]
    private ?string $old_email = null;

    #[ORM\Column(length: 1)]
    private ?string $activity = null;

   

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Categorie::class)]
    private Collection $categories;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: BonDeCommande::class)]
    private Collection $bonDeCommandes;

    

    public function __construct()
    {
        
        $this->categories = new ArrayCollection();
        $this->bonDeCommandes = new ArrayCollection();
        
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->First_Name;
    }

    public function setFirstName(string $First_Name): static
    {
        $this->First_Name = $First_Name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->Last_Name;
    }

    public function setLastName(string $Last_Name): static
    {
        $this->Last_Name = $Last_Name;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->Gender;
    }

    public function setGender(string $Gender): static
    {
        $this->Gender = $Gender;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(?string $Address): static
    {
        $this->Address = $Address;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->Phone_Number;
    }

    public function setPhoneNumber(?int $Phone_Number): static
    {
        $this->Phone_Number = $Phone_Number;

        return $this;
    }

    public function getCIN(): ?int
    {
        return $this->CIN;
    }

    public function setCIN(int $CIN): static
    {
        $this->CIN = $CIN;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->Created_At;
    }

    public function setCreatedAt(\DateTimeImmutable $Created_At): static
    {
        $this->Created_At = $Created_At;

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
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getOldEmail(): ?string
    {
        return $this->old_email;
    }

    public function setOldEmail(string $old_email): static
    {
        $this->old_email = $old_email;

        return $this;
    }

    public function getActivity(): ?string
    {
        return $this->activity;
    }

    public function setActivity(string $activity): static
    {
        $this->activity = $activity;

        return $this;
    }

    public function __toString(): string
    {
        return $this->First_Name . ' ' . $this->Last_Name;
    }

   
    /**
     * @return Collection<int, Categorie>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->setUser($this);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): static
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getUser() === $this) {
                $category->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BonDeCommande>
     */
    public function getBonDeCommandes(): Collection
    {
        return $this->bonDeCommandes;
    }

    public function addBonDeCommande(BonDeCommande $bonDeCommande): static
    {
        if (!$this->bonDeCommandes->contains($bonDeCommande)) {
            $this->bonDeCommandes->add($bonDeCommande);
            $bonDeCommande->setUser($this);
        }

        return $this;
    }

    public function removeBonDeCommande(BonDeCommande $bonDeCommande): static
    {
        if ($this->bonDeCommandes->removeElement($bonDeCommande)) {
            // set the owning side to null (unless already changed)
            if ($bonDeCommande->getUser() === $this) {
                $bonDeCommande->setUser(null);
            }
        }

        return $this;
    }

    
}
