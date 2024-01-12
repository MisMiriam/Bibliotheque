<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use App\Repository\LivreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
#[ApiResource(
    /* Affiche seulement le titre et l'id dans le get livre  */ 
    normalizationContext: ['groups' => ['read:book']],
    /* Affiche seulement les informations modifiables dans le post livre */
    denormalizationContext: ['groups' => ['write.book']],),
    ApiFilter(SearchFilter::class, properties: ['categorie' => 'exact'])] // Filtre les livres par categories 
    
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:book'])]
    private ?int $id = null;

    #[Groups(['read:book', 'write.book'])]
    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[Groups(['read:book', 'write.book'])]
    #[ORM\Column(length: 255)]
    private ?string $auteur = null;

    #[Groups(['read:book'])]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_publication = null;

    #[Groups(['read:book', 'write.book'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $resume = null;

    #[Groups(['read:book', 'write.book'])]
    #[ORM\Column(nullable: true)]
    private ?int $nb_tome = null;

    #[Groups(['read:book'])]
    #[ORM\ManyToOne(inversedBy: 'livre')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->date_publication;
    }

    public function setDatePublication(\DateTimeInterface $date_publication): static
    {
        $this->date_publication = $date_publication;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(?string $resume): static
    {
        $this->resume = $resume;

        return $this;
    }

    public function getNbTome(): ?int
    {
        return $this->nb_tome;
    }

    public function setNbTome(?int $nb_tome): static
    {
        $this->nb_tome = $nb_tome;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
}
