<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\SousCategorieRepository")
 */
class SousCategorie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $titre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="sousCategories")
     * @ORM\JoinColumn(nullable=false)
     * Assert\length(min = 5, max = 50,
     *      minMessage = "le titre doit contenir {{ limit }} charactères au minimum",
     *      maxMessage = "le titre doit contenir {{ limit }} charactères au maximum")
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProduitCategorie", mappedBy="sousCategorie", orphanRemoval=true)
     */
    private $produitCategories;

    public function __construct()
    {
        $this->produitCategories = new ArrayCollection();
        $this->atelierCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|ProduitCategorie[]
     */
    public function getProduitCategories(): Collection
    {
        return $this->produitCategories;
    }

    public function addProduitCategory(ProduitCategorie $produitCategory): self
    {
        if (!$this->produitCategories->contains($produitCategory)) {
            $this->produitCategories[] = $produitCategory;
            $produitCategory->setSousCategorie($this);
        }

        return $this;
    }

    public function removeProduitCategory(ProduitCategorie $produitCategory): self
    {
        if ($this->produitCategories->contains($produitCategory)) {
            $this->produitCategories->removeElement($produitCategory);
            // set the owning side to null (unless already changed)
            if ($produitCategory->getSousCategorie() === $this) {
                $produitCategory->setSousCategorie(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->titre;
    }
}
