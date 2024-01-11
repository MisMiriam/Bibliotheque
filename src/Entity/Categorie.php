<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[ApiResource, ApiFilter(SearchFilter::class, properties: ['categorie' => 'exact', 'nom_categorie' => 'exact'])]
// #[ApiResource, ApiFilter(SearchFilter::class, properties: ['nom_categorie' => 'exact'])]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_categorie = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Livre::class)]
    private Collection $livre;

    // #[ORM\Column(length: 255, nullable: true)] // Ajout de "nullable: true"
    // private ?string $nom_categorie = null;

    public function __construct()
    {
        $this->livre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCategorie(): ?string
    {
        return $this->nom_categorie;
    }

    public function setNomCategorie(string $nom_categorie): static
    {
        $this->nom_categorie = $nom_categorie;

        return $this;
    }

    /**
     * @return Collection<int, Livre>
     */
    public function getLivre(): Collection
    {
        return $this->livre;
    }

    public function addLivre(Livre $livre): static
    {
        if (!$this->livre->contains($livre)) {
            $this->livre->add($livre);
            $livre->setCategorie($this);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): static
    {
        if ($this->livre->removeElement($livre)) {
            // set the owning side to null (unless already changed)
            if ($livre->getCategorie() === $this) {
                $livre->setCategorie(null);
            }
        }

        return $this;
    }
}
