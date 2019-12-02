<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @UniqueEntity(fields={"name"}, message="Cette catégorie existe déjà.")
 *
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     * @Assert\NotBlank(message="Le nom est obligatoire") // Pour contrôler que le champ n'est pas vide (Rajoute use Symfony\Component\Validator\Constraints as Assert;)
     * @Assert\Length(max="20", maxMessage="Le nom ne doit pas dépasser 20 caractères") // Si le nom comporte plus de 20 caractères...
     * @Assert\Length(min="2", minMessage="Le nom  doit contenir au moins 2 caractères") // Si le nom comporte moins de 2 caractères...
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
