<?php

namespace App\Entity;

use App\Repository\AgenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgenceRepository::class)
 */
class Agence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $tel_agence;

    /**
     * @ORM\OneToMany(targetEntity=Voiture::class, mappedBy="agence")
     */
    private $idAgence;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $adresseville;

    public function __construct()
    {
        $this->idAgence = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTelAgence(): ?int
    {
        return $this->tel_agence;
    }

    public function setTelAgence(int $tel_agence): self
    {
        $this->tel_agence = $tel_agence;

        return $this;
    }

    /**
     * @return Collection|Voiture[]
     */
    public function getIdAgence(): Collection
    {
        return $this->idAgence;
    }

    public function addIdAgence(voiture $idAgence): self
    {
        if (!$this->idAgence->contains($idAgence)) {
            $this->idAgence[] = $idAgence;
            $idAgence->setAgence($this);
        }

        return $this;
    }

    public function removeIdAgence(voiture $idAgence): self
    {
        if ($this->idAgence->removeElement($idAgence)) {
            // set the owning side to null (unless already changed)
            if ($idAgence->getAgence() === $this) {
                $idAgence->setAgence(null);
            }
        }

        return $this;
    }

    public function getAdresseville(): ?string
    {
        return $this->adresseville;
    }

    public function setAdresseville(string $adresseville): self
    {
        $this->adresseville = $adresseville;

        return $this;
    }
}
