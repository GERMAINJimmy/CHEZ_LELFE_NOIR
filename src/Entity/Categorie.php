<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\OneToMany(targetEntity=Atelier::class, mappedBy="categorie")
     */
    private $ateliers;

    public function __construct()
    {
        $this->sousCategories = new ArrayCollection();
        $this->ateliers = new ArrayCollection();
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
    public function __toString()
    {
        return $this->titre;
    }

    /**
     * @return Collection|Atelier[]
     */
    public function getAteliers(): Collection
    {
        return $this->ateliers;
    }

    public function addAtelier(Atelier $atelier): self
    {
        if (!$this->ateliers->contains($atelier)) {
            $this->ateliers[] = $atelier;
            $atelier->setCategorie($this);
        }

        return $this;
    }

    public function removeAtelier(Atelier $atelier): self
    {
        if ($this->ateliers->contains($atelier)) {
            $this->ateliers->removeElement($atelier);
            // set the owning side to null (unless already changed)
            if ($atelier->getCategorie() === $this) {
                $atelier->setCategorie(null);
            }
        }

        return $this;
    }
}
