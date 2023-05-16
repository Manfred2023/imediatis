<?php

class CertificationDB
{
    private int $id;
    private string $name;
    private int $year;
    private ?string $description;

    public function __construct(int $id, string $name, int $year, string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->year = $year;
        $this->description = $description;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}