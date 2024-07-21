<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column]
    private ?int $Qte = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    private ?Categorie $category = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: BonDeCommande::class)]
    private Collection $bonDeCommandes;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    private ?User $user = null;

    public function __construct()
    {
        $this->bonDeCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQte(): ?int
    {
        return $this->Qte;
    }

    public function setQte(int $Qte): static
    {
        $this->Qte = $Qte;

        return $this;
    }

    public function getCategory(): ?categorie
    {
        return $this->category;
    }

    public function setCategory(?categorie $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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
            $bonDeCommande->setProduit($this);
        }

        return $this;
    }

    public function removeBonDeCommande(BonDeCommande $bonDeCommande): static
    {
        if ($this->bonDeCommandes->removeElement($bonDeCommande)) {
            // set the owning side to null (unless already changed)
            if ($bonDeCommande->getProduit() === $this) {
                $bonDeCommande->setProduit(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }
}
