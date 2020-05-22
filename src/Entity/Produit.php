<?php

namespace App\Entity;

use App\Entity\ProduitCategorie;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 * @Vich\Uploadable
 */
class Produit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * Assert\EqualTo("{{ $titre }}	")
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=50)
     * Assert\length(min = 5, max = 50,
     *      minMessage = "le titre doit contenir {{ limit }} charactères au minimum",
     *      maxMessage = "le titre doit contenir {{ limit }} charactères au maximum",
     *      allowEmptyString = false)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $couleur;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private $public;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     * @Assert\Image(
     *     minWidth = 600,
     *     maxWidth = 600,
     *     minHeight = 600,
     *     maxHeight = 600)
     */
    private $photo;

    /**
     * @Vich\UploadableField(mapping="featured_images", fileNameProperty="featured_images")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $taille;

    /**
     * @Gedmo\Slug(fields={"titre"})
     * @ORM\Column(length=128, unique=true)
     * Assert\EqualTo("{{ $titre }}	")
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProduitCategorie", mappedBy="produit", orphanRemoval=true)
     */
    private $produitCategories;

    /**
     * @var \DateTime $dateEnregistrement
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $dateEnregistrement;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ProduitCommande", mappedBy="produit")
     */
    private $produitCommandes;

    /**
     * @var \DateTime $dateModification
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $dateModification;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Promotion", mappedBy="produit")
     */
    private $promotions;

    public function __construct()
    {
        $this->dateEnregistrement = new \DateTime();
        $this->produitCategories = new ArrayCollection();
        $this->produitCommandes = new ArrayCollection();
        $this->promotions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getPublic(): ?string
    {
        return $this->public;
    }

    public function setPublic(string $public): self
    {
        $this->public = $public;

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

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }
    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if($image){
            $this->dateModification = new \DateTime('now');
        }
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

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

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
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
            $produitCategory->setProduit($this);
        }

        return $this;
    }

    public function removeProduitCategory(ProduitCategorie $produitCategory): self
    {
        if ($this->produitCategories->contains($produitCategory)) {
            $this->produitCategories->removeElement($produitCategory);
            // set the owning side to null (unless already changed)
            if ($produitCategory->getProduit() === $this) {
                $produitCategory->setProduit(null);
            }
        }

        return $this;
    }

    public function getDateEnregistrement(): ?\DateTimeInterface
    {
        return $this->dateEnregistrement;
    }
    public function __toString()
    {
        return $this->titre;
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
            $produitCommande->addProduit($this);
        }

        return $this;
    }

    public function removeProduitCommande(ProduitCommande $produitCommande): self
    {
        if ($this->produitCommandes->contains($produitCommande)) {
            $this->produitCommandes->removeElement($produitCommande);
            $produitCommande->removeProduit($this);
        }

        return $this;
    }

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->dateModification;
    }

    /**
     * @return Collection|Promotion[]
     */
    public function getPromotions(): Collection
    {
        return $this->promotions;
    }

    public function addPromotion(Promotion $promotion): self
    {
        if (!$this->promotions->contains($promotion)) {
            $this->promotions[] = $promotion;
            $promotion->setProduit($this);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): self
    {
        if ($this->promotions->contains($promotion)) {
            $this->promotions->removeElement($promotion);
            // set the owning side to null (unless already changed)
            if ($promotion->getProduit() === $this) {
                $promotion->setProduit(null);
            }
        }

        return $this;
    }
}
