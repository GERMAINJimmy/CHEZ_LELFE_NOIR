<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * Assert\length(min = 5, max = 50,
     *      minMessage = "le titre doit contenir {{ limit }} charactères au minimum",
     *      maxMessage = "le titre doit contenir {{ limit }} charactères au maximum",
     *      allowEmptyString = false)
     */
    private $titre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SousCategorie", mappedBy="categorie", orphanRemoval=true)
     */
    private $sousCategories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProduitCategorie", mappedBy="categorie", orphanRemoval=true)
     */
    private $produitCategories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AtelierCategorie", mappedBy="categorie", orphanRemoval=true)
     */
    private $atelierCategories;

    public function __construct()
    {
        $this->sousCategories = new ArrayCollection();
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

    /**
     * @return Collection|SousCategorie[]
     */
    public function getSousCategories(): Collection
    {
        return $this->sousCategories;
    }

    public function addSousCategory(SousCategorie $sousCategory): self
    {
        if (!$this->sousCategories->contains($sousCategory)) {
            $this->sousCategories[] = $sousCategory;
            $sousCategory->setCategorie($this);
        }

        return $this;
    }

    public function removeSousCategory(SousCategorie $sousCategory): self
    {
        if ($this->sousCategories->contains($sousCategory)) {
            $this->sousCategories->removeElement($sousCategory);
            // set the owning side to null (unless already changed)
            if ($sousCategory->getCategorie() === $this) {
                $sousCategory->setCategorie(null);
            }
        }

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
            $produitCategory->setCategorie($this);
        }

        return $this;
    }

    public function removeProduitCategory(ProduitCategorie $produitCategory): self
    {
        if ($this->produitCategories->contains($produitCategory)) {
            $this->produitCategories->removeElement($produitCategory);
            // set the owning side to null (unless already changed)
            if ($produitCategory->getCategorie() === $this) {
                $produitCategory->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AtelierCategorie[]
     */
    public function getAtelierCategories(): Collection
    {
        return $this->atelierCategories;
    }

    public function addAtelierCategory(AtelierCategorie $atelierCategory): self
    {
        if (!$this->atelierCategories->contains($atelierCategory)) {
            $this->atelierCategories[] = $atelierCategory;
            $atelierCategory->setCategorie($this);
        }

        return $this;
    }

    public function removeAtelierCategory(AtelierCategorie $atelierCategory): self
    {
        if ($this->atelierCategories->contains($atelierCategory)) {
            $this->atelierCategories->removeElement($atelierCategory);
            // set the owning side to null (unless already changed)
            if ($atelierCategory->getCategorie() === $this) {
                $atelierCategory->setCategorie(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->titre;
    }
}
