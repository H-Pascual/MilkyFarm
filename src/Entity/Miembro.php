<?php

namespace App\Entity;

use App\Repository\MiembroRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MiembroRepository::class)]
class Miembro
{
    const RUTA_MIEMBROS = '/img/miembros/';

    public function getUrlMiembros(): string
    {
        return self::RUTA_MIEMBROS . $this->getImagen();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagen = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $trabajo = null;

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

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(?string $imagen): static
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getTrabajo(): ?string
    {
        return $this->trabajo;
    }

    public function setTrabajo(?string $trabajo): static
    {
        $this->trabajo = $trabajo;

        return $this;
    }
}
