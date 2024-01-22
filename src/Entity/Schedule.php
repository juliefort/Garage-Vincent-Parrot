<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $days = null;

    #[ORM\Column(length: 100)]
    private ?string $opening_hour = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDays(): ?string
    {
        return $this->days;
    }

    public function setDays(string $days): static
    {
        $this->days = $days;

        return $this;
    }

    public function getOpeningHour(): ?string
    {
        return $this->opening_hour;
    }

    public function setOpeningHour(string $opening_hour): static
    {
        $this->opening_hour = $opening_hour;

        return $this;
    }
}
