<?php

namespace App\Entity;

use App\Repository\TitleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TitleRepository::class)
 */
class Title
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @var
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank
     * @var
     */
    private $description;

    /**
     * @ORM\Column(type="string")
     */
    private $coverFilename;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @var
     */
    private $tag;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="integer")
     */
    private $year;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCoverFilename()
    {
        return $this->coverFilename;
    }

    public function setCoverFilename($coverFileName): self
    {
        $this->coverFilename = $coverFileName;

        return $this;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function getYear()
    {
        return $this->year;
    }


    public function setYear($year): void
    {
        $this->year = $year;
    }
}
