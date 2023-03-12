<?php

namespace App\Entity;

use App\Enum\ResumeStatus;
use App\Repository\ResumeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ResumeRepository::class)]
class Resume
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    #[Assert\Choice(ResumeStatus::STATUSES, groups: ['status'])]
    private ?string $status = null;

    #[ORM\Column(length: 128)]
    private ?string $firstName = null;

    #[ORM\Column(length: 128)]
    private ?string $lastName = null;

    #[ORM\Column(length: 128, nullable: true)]
    private ?string $patronymic = null;

    #[ORM\Column(length: 128)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $profession = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\Column(length: 10, unique: true)]
    private ?string $phone = null;

    #[ORM\Column(nullable: true)]
    private ?int $expectedSalary = null;

    #[ORM\Column(length: 512, nullable: true)]
    private ?string $skills = null;

    #[ORM\Column(length: 2048, nullable: true)]
    private ?string $experience = null;

    #[ORM\Column(length: 2048, nullable: true)]
    private ?string $about = null;

    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $imagePreview = null;

    #[ORM\OneToMany(mappedBy: 'resume', targetEntity: Education::class)]
    private Collection $educations;

    public function __construct(?int $id, ?string $status, ?string $firstName, ?string $lastName, ?string $patronymic, ?string $city, ?string $profession, ?string $email, ?\DateTimeInterface $birthdate, ?string $phone, ?int $expectedSalary, ?string $skills, ?string $experience, ?string $about, ?string $imagePreview)
    {
        $this->id = $id;
        $this->status = $status;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->patronymic = $patronymic;
        $this->city = $city;
        $this->profession = $profession;
        $this->email = $email;
        $this->birthdate = $birthdate;
        $this->phone = $phone;
        $this->expectedSalary = $expectedSalary;
        $this->skills = $skills;
        $this->experience = $experience;
        $this->about = $about;
        $this->imagePreview = $imagePreview;
        $this->educations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getImagePreview(): ?string
    {
        return $this->imagePreview;
    }

    public function setImagePreview(?string $imagePreview): self
    {
        $this->imagePreview = $imagePreview;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    public function setPatronymic(?string $patronymic): self
    {
        $this->patronymic = $patronymic;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getExpectedSalary(): ?int
    {
        return $this->expectedSalary;
    }

    public function setExpectedSalary(?int $expectedSalary): self
    {
        $this->expectedSalary = $expectedSalary;

        return $this;
    }

    public function getSkills(): ?string
    {
        return $this->skills;
    }

    public function setSkills(?string $skills): self
    {
        $this->skills = $skills;

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(?string $about): self
    {
        $this->about = $about;

        return $this;
    }

    /**
     * @return Collection<int, Education>
     */
    public function getEducations(): Collection
    {
        return $this->educations;
    }

    public function addEducation(Education $education): self
    {
        if (!$this->educations->contains($education)) {
            $this->educations->add($education);
            $education->setResume($this);
        }

        return $this;
    }

    public function removeEducation(Education $education): self
    {
        if ($this->educations->removeElement($education)) {
            // set the owning side to null (unless already changed)
            if ($education->getResume() === $this) {
                $education->setResume(null);
            }
        }

        return $this;
    }

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(?string $experience): self
    {
        $this->experience = $experience;

        return $this;
    }
}
