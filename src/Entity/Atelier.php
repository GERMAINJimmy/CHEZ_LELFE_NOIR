<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass="App\Repository\AtelierRepository")
 * @Vich\Uploadable
 */
class Atelier
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
     * @ORM\Column(type="integer")
     */
    private $duree;

    /**
     * @ORM\Column(type="integer")
     */
    private $place;

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
 * @Vich\UploadableField(mapping="featured_images", fileNameProperty="featured_image")
 * @var File
 */
private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $video;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @Gedmo\Slug(fields={"titre"})
     * @ORM\Column(length=128, unique=true)
     * Assert\EqualTo("{{ $titre }}	")
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AtelierCommande", mappedBy="atelier")
     */
    private $atelierCommandes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AtelierCategorie", mappedBy="atelier", orphanRemoval=true)
     */
    private $atelierCategories;

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
        $this->atelierCommandes = new ArrayCollection();
        $this->atelierCategories = new ArrayCollection();
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

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getPlace(): ?int
    {
        return $this->place;
    }

    public function setPlace(int $place): self
    {
        $this->place = $place;

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

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
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

    public function getSlug(): ?string
    {
        return $this->slug;
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
            $atelierCommande->setAtelier($this);
        }

        return $this;
    }

    public function removeAtelierCommande(AtelierCommande $atelierCommande): self
    {
        if ($this->atelierCommandes->contains($atelierCommande)) {
            $this->atelierCommandes->removeElement($atelierCommande);
            // set the owning side to null (unless already changed)
            if ($atelierCommande->getAtelier() === $this) {
                $atelierCommande->setAtelier(null);
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
            $atelierCategory->setAtelier($this);
        }

        return $this;
    }

    public function removeAtelierCategory(AtelierCategorie $atelierCategory): self
    {
        if ($this->atelierCategories->contains($atelierCategory)) {
            $this->atelierCategories->removeElement($atelierCategory);
            // set the owning side to null (unless already changed)
            if ($atelierCategory->getAtelier() === $this) {
                $atelierCategory->setAtelier(null);
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

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->dateModification;
    }
}
