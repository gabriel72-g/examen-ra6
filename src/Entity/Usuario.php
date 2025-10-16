<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class Usuario implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];


    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre_apellidos = null;

    #[ORM\Column]
    private ?bool $profesor = null;

    /**
     * @var Collection<int, Instrumento>
     */
    #[ORM\OneToMany(targetEntity: Instrumento::class, mappedBy: 'imparte')]
    private Collection $imparte;

    /**
     * @var Collection<int, Instrumento>
     */
    #[ORM\ManyToMany(targetEntity: Instrumento::class, inversedBy: 'matricula')]
    private Collection $matricula;

    /**
     * @var Collection<int, Matricula>
     */
    #[ORM\OneToMany(targetEntity: Matricula::class, mappedBy: 'alumnoMatricula')]
    private Collection $matriculas;

    public function __construct()
    {
        $this->imparte = new ArrayCollection();
        $this->matricula = new ArrayCollection();
        $this->matriculas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getNombreApellidos(): ?string
    {
        return $this->nombre_apellidos;
    }

    public function setNombreApellidos(string $nombre_apellidos): static
    {
        $this->nombre_apellidos = $nombre_apellidos;

        return $this;
    }

    public function isProfesor(): ?bool
    {
        return $this->profesor;
    }

    public function setProfesor(bool $profesor): static
    {
        $this->profesor = $profesor;

        return $this;
    }

    /**
     * @return Collection<int, Instrumento>
     */
    public function getImparte(): Collection
    {
        return $this->imparte;
    }

    public function addImparte(Instrumento $imparte): static
    {
        if (!$this->imparte->contains($imparte)) {
            $this->imparte->add($imparte);
            $imparte->setImparte($this);
        }

        return $this;
    }

    public function removeImparte(Instrumento $imparte): static
    {
        if ($this->imparte->removeElement($imparte)) {
            // set the owning side to null (unless already changed)
            if ($imparte->getImparte() === $this) {
                $imparte->setImparte(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Instrumento>
     */
    public function getMatricula(): Collection
    {
        return $this->matricula;
    }

    public function addMatricula(Instrumento $matricula): static
    {
        if (!$this->matricula->contains($matricula)) {
            $this->matricula->add($matricula);
        }

        return $this;
    }

    public function removeMatricula(Instrumento $matricula): static
    {
        $this->matricula->removeElement($matricula);

        return $this;
    }
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials(): void
    {
        // No es necesario implementar nada si no hay datos sensibles
    }

    /**
     * @return Collection<int, Matricula>
     */
    public function getMatriculas(): Collection
    {
        return $this->matriculas;
    }
}
