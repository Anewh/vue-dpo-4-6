<?php

namespace App\Entity;

use App\Repository\EducationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: EducationRepository::class)]
class Education
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $institute = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $faculty = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $specialization = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $endYear = null;

    #[ORM\ManyToOne(inversedBy: 'educations')]
    #[Ignore]
    private ?Resume $resume = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getInstitute(): ?string
    {
        return $this->institute;
    }

    public function setInstitute(?string $institute): self
    {
        $this->institute = $institute;

        return $this;
    }

    public function getFaculty(): ?string
    {
        return $this->faculty;
    }

    public function setFaculty(?string $faculty): self
    {
        $this->faculty = $faculty;

        return $this;
    }

    public function getSpecialization(): ?string
    {
        return $this->specialization;
    }

    public function setSpecialization(?string $specialization): self
    {
        $this->specialization = $specialization;

        return $this;
    }

    public function getEndYear(): ?int
    {
        return $this->endYear;
    }

    public function setEndYear(?int $endYear): self
    {
        $this->endYear = $endYear;

        return $this;
    }

    public function getResume(): ?Resume
    {
        return $this->resume;
    }

    public function setResume(?Resume $resume): self
    {
        $this->resume = $resume;

        return $this;
    }
}
