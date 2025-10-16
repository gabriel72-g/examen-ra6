<?php

namespace App\Entity;

use App\Repository\InstrumentoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstrumentoRepository::class)]
class Instrumento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\ManyToOne(inversedBy: 'imparte')]
    private ?Usuario $imparte = null;

    /**
     * @var Collection<int, Usuario>
     */
    #[ORM\ManyToMany(targetEntity: Usuario::class, mappedBy: 'matricula')]
    private Collection $matricula;

    /**
     * @var Collection<int, Matricula>
     */
    #[ORM\OneToMany(targetEntity: Matricula::class, mappedBy: 'instrumentoMatricula')]
    private Collection $alumnoMatricula;

    public function __construct()
    {
        $this->matricula = new ArrayCollection();
        $this->alumnoMatricula = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getImparte(): ?Usuario
    {
        return $this->imparte;
    }

    public function setImparte(?Usuario $imparte): static
    {
        $this->imparte = $imparte;

        return $this;
    }

    /**
     * @return Collection<int, Usuario>
     */
    public function getMatricula(): Collection
    {
        return $this->matricula;
    }

    public function addMatricula(Usuario $matricula): static
    {
        if (!$this->matricula->contains($matricula)) {
            $this->matricula->add($matricula);
            $matricula->addMatricula($this);
        }

        return $this;
    }

    public function removeMatricula(Usuario $matricula): static
    {
        if ($this->matricula->removeElement($matricula)) {
            $matricula->removeMatricula($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Matricula>
     */
    public function getAlumnoMatricula(): Collection
    {
        return $this->alumnoMatricula;
    }

    public function addAlumnoMatricula(Matricula $alumnoMatricula): static
    {
        if (!$this->alumnoMatricula->contains($alumnoMatricula)) {
            $this->alumnoMatricula->add($alumnoMatricula);
            $alumnoMatricula->setInstrumentoMatricula($this);
        }

        return $this;
    }

    public function removeAlumnoMatricula(Matricula $alumnoMatricula): static
    {
        if ($this->alumnoMatricula->removeElement($alumnoMatricula)) {
            // set the owning side to null (unless already changed)
            if ($alumnoMatricula->getInstrumentoMatricula() === $this) {
                $alumnoMatricula->setInstrumentoMatricula(null);
            }
        }

        return $this;
    }
}
