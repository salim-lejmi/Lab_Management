<?php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: \App\Repository\EquipmentRepository::class)]

class Equipment
{
   #[ORM\Id]
   #[ORM\GeneratedValue]
   #[ORM\Column]
   private ?int $id = null;

   #[ORM\Column(length: 255)]
   #[Assert\NotBlank]
   private ?string $name = null;

   #[ORM\Column(type: "text")]
   #[Assert\NotBlank]
   private ?string $description = null;

   #[ORM\Column(length: 255)]
   #[Assert\Url]
   private ?string $photoUrl = null;
   #[ORM\ManyToMany(targetEntity: Project::class, mappedBy: "equipments")]
   private Collection $projects;
   public function __construct()
{
    $this->projects = new ArrayCollection();
}

   public function getId(): ?int
   {
       return $this->id;
   }

   public function getName(): ?string
   {
       return $this->name;
   }

   public function setName(?string $name): void
   {
       $this->name = $name;
   }

   public function getDescription(): ?string
   {
       return $this->description;
   }

   public function setDescription(?string $description): void
   {
       $this->description = $description;
   }

   public function getPhotoUrl(): ?string
   {
       return $this->photoUrl;
   }

   public function setPhotoUrl(?string $photoUrl): void
   {
       $this->photoUrl = $photoUrl;
   }
   /**
 * @return Collection<int, Project>
 */
public function getProjects(): Collection
{
    return $this->projects;
}

public function addProject(Project $project): self
{
    if (!$this->projects->contains($project)) {
        $this->projects[] = $project;
        $project->addEquipment($this);
    }

    return $this;
}

public function removeProject(Project $project): self
{
    if ($this->projects->removeElement($project)) {
        $project->removeEquipment($this);
    }

    return $this;
}

}
