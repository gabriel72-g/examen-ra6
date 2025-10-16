<?php

namespace App\Entity;

use App\Repository\MatriculaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatriculaRepository::class)]
class Matricula
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'alumnoMatricula')]
    private ?Instrumento $instrumentoMatricula = null;

    #[ORM\ManyToOne(inversedBy: 'matriculas')]
    private ?Usuario $alumnoMatricula = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInstrumentoMatricula(): ?Instrumento
    {
        return $this->instrumentoMatricula;
    }

    public function setInstrumentoMatricula(?Instrumento $instrumentoMatricula): static
    {
        $this->instrumentoMatricula = $instrumentoMatricula;

        return $this;
    }

    public function getAlumnoMatricula(): ?Usuario
    {
        return $this->alumnoMatricula;
    }

    public function setAlumnoMatricula(?Usuario $alumnoMatricula): static
    {
        $this->alumnoMatricula = $alumnoMatricula;

        return $this;
    }
}
