<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;


    #[ORM\Column(length: 255)]
    private ?string $username = null;
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'projects')]
    private ?User $author = null;
        #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'projects')]
    private Collection $users;



    
    #[ORM\ManyToMany(targetEntity: Equipment::class, inversedBy: "projects")]
    private Collection $equipments;
    #[ORM\ManyToMany(targetEntity: Publication::class)]
private $publications;


    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->equipments = new ArrayCollection();
        $this->publications = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
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

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addProject($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeProject($this);
        }

        return $this;
    }
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }
    public function getEquipments(): Collection
    {
       return $this->equipments;
    }
    

    public function addEquipment(Equipment $equipment): self
    {
        if (!$this->equipments->contains($equipment)) {
            $this->equipments[] = $equipment;
            $equipment->addProject($this);
        }
    
        return $this;
    }
    
    public function removeEquipment(Equipment $equipment): self
    {
        if ($this->equipments->removeElement($equipment)) {
            $equipment->removeProject($this);
        }
    
        return $this;
    }
    public function getPublications(): Collection
{
    return $this->publications;
}

public function addPublication(Publication $publication): self
{
    if (!$this->publications->contains($publication)) {
        $this->publications[] = $publication;
    }

    return $this;
}

public function removePublication(Publication $publication): self
{
    $this->publications->removeElement($publication);

    return $this;
}

    }