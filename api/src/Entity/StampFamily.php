<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StampFamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=StampFamilyRepository::class)
 */
class StampFamily
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\OneToMany(targetEntity=stamp::class, mappedBy="family")
     */
    private $stamps;

    public function __construct()
    {
        $this->stamps = new ArrayCollection();
    }

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

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return Collection|stamp[]
     */
    public function getStamps(): Collection
    {
        return $this->stamps;
    }

    public function addStamp(stamp $stamp): self
    {
        if (!$this->stamps->contains($stamp)) {
            $this->stamps[] = $stamp;
            $stamp->setFamily($this);
        }

        return $this;
    }

    public function removeStamp(stamp $stamp): self
    {
        if ($this->stamps->removeElement($stamp)) {
            // set the owning side to null (unless already changed)
            if ($stamp->getFamily() === $this) {
                $stamp->setFamily(null);
            }
        }

        return $this;
    }
}
