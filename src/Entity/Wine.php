<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Service\UploaderHelper;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WineRepository")
 */
class Wine
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=4, nullable=true)
     */
    private $vintage;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $grape;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $region;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageFilename;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_modified;

    /**
     * @ORM\Column(type="integer")
     */
    private $author;

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
        $this->name = strtolower($name);

        return $this;
    }

    public function getVintage(): ?string
    {
        return $this->vintage;
    }

    public function setVintage(?string $vintage): self
    {
        $this->vintage = $vintage;

        return $this;
    }

    public function getGrape(): ?string
    {
        return $this->grape;
    }

    public function setGrape(?string $grape): self
    {
        $this->grape = strtolower($grape);

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = strtolower($country);

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = strtolower($region);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = strtolower($description);

        return $this;
    }

    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    public function getImagePath(): ?string
    {
        return UploaderHelper::getPublicPath() . '/' . UploaderHelper::IMAGES . '/' . $this->getImageFilename();
    }

    public function setImageFilename(?string $imageFilename): self
    {
        $this->imageFilename = $imageFilename;

        return $this;
    }

    public function getDateModified(): ?\DateTimeInterface
    {
        return $this->date_modified;
    }

    public function setDateModified(?\DateTimeInterface $date_modified): self
    {
        $this->date_modified = $date_modified;

        return $this;
    }

    public function getAuthor(): ?int
    {
        return $this->author;
    }

    public function setAuthor(?int $author): self
    {
        $this->author = $author;

        return $this;
    }
}
