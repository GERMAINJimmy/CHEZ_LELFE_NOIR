<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="commandes")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProduitCommande", mappedBy="commmande")
     */
    private $produitCommandes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AtelierCommande", mappedBy="commande")
     */
    private $atelierCommandes;

    /**
     * @var \DateTime $dateEnregistrement
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $dateEnregistrement;

    /**
     * @var \DateTime $dateModification
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $dateModification;

    public function __construct()
    {
        $this->produitCommandes = new ArrayCollection();
        $this->atelierCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|ProduitCommande[]
     */
    public function getProduitCommandes(): Collection
    {
        return $this->produitCommandes;
    }

    public function addProduitCommande(ProduitCommande $produitCommande): self
    {
        if (!$this->produitCommandes->contains($produitCommande)) {
            $this->produitCommandes[] = $produitCommande;
            $produitCommande->setCommmande($this);
        }

        return $this;
    }

    public function removeProduitCommande(ProduitCommande $produitCommande): self
    {
        if ($this->produitCommandes->contains($produitCommande)) {
            $this->produitCommandes->removeElement($produitCommande);
            // set the owning side to null (unless already changed)
            if ($produitCommande->getCommmande() === $this) {
                $produitCommande->setCommmande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AtelierCommande[]
     */
    public function getAtelierCommandes(): Collection
    {
        return $this->atelierCommandes;
    }

    public function addAtelierCommande(AtelierCommande $atelierCommande): self
    {
        if (!$this->atelierCommandes->contains($atelierCommande)) {
            $this->atelierCommandes[] = $atelierCommande;
            $atelierCommande->setCommande($this);
        }

        return $this;
    }

    public function removeAtelierCommande(AtelierCommande $atelierCommande): self
    {
        if ($this->atelierCommandes->contains($atelierCommande)) {
            $this->atelierCommandes->removeElement($atelierCommande);
            // set the owning side to null (unless already changed)
            if ($atelierCommande->getCommande() === $this) {
                $atelierCommande->setCommande(null);
            }
        }

        return $this;
    }

    public function getDateEnregistrement(): ?\DateTimeInterface
    {
        return $this->dateEnregistrement;
    }

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->dateModification;
    }
}
