<?php

namespace App\Entity;

use App\Repository\CarsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\FormTypeInterface;

#[ORM\Entity(repositoryClass: CarsRepository::class)]
class Cars
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $Brand = null;

    #[ORM\Column(length: 50)]
    private ?string $Model = null;

    #[ORM\Column]
    private ?int $Year = null;

    #[ORM\Column]
    private ?int $kilometers = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    /*#[ORM\Column(type: Types::BLOB, nullable: true)]
    private $Image1 = null;*/

    #[ORM\Column(length: 50)]
    private ?string $TypeFuel = null;

    #[ORM\OneToMany(mappedBy: 'cars', targetEntity: Images::class)]
    private Collection $Images;

    public function __construct()
    {
        $this->Images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->Brand;
    }

    public function setBrand(string $Brand): self
    {
        $this->Brand = $Brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->Model;
    }

    public function setModel(string $Model): self
    {
        $this->Model = $Model;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->Year;
    }

    public function setYear(int $Year): self
    {
        $this->Year = $Year;

        return $this;
    }

    public function getKilometers(): ?int
    {
        return $this->kilometers;
    }

    public function setKilometers(int $kilometers): self
    {
        $this->kilometers = $kilometers;

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

    /*public function getImage1()
    {
        return $this->Image1;
    }

    public function setImage1($Image1): self
    {
        $this->Image1 = $Image1;

        return $this;
    }*/

    public function getTypeFuel(): ?string
    {
        return $this->TypeFuel;
    }

    public function setTypeFuel(string $TypeFuel): self
    {
        $this->TypeFuel = $TypeFuel;

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->Images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->Images->contains($image)) {
            $this->Images->add($image);
            $image->setCars($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->Images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getCars() === $this) {
                $image->setCars(null);
            }
        }

        return $this;
    }
}
