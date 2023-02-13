<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\Column(type: 'text')]
    private $contenu;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'evenements')]
    #[ORM\JoinColumn(nullable: false)]
    private $user_id;

    #[ORM\Column(type: 'integer')]
    private $Attendant;

    #[ORM\OneToMany(mappedBy: 'event_id', targetEntity: Commentaire::class, orphanRemoval: true)]
    private $commentaires;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'attendant')]
    private $Attendant_id;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->Attendant_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getAttendant(): ?int
    {
        return $this->Attendant;
    }

    public function setAttendant(int $Attendant): self
    {
        $this->Attendant = $Attendant;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setEventId($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getEventId() === $this) {
                $commentaire->setEventId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getAttendantId(): Collection
    {
        return $this->Attendant_id;
    }

    public function addAttendantId(User $attendantId): self
    {
        if (!$this->Attendant_id->contains($attendantId)) {
            $this->Attendant_id[] = $attendantId;
        }

        return $this;
    }

    public function removeAttendantId(User $attendantId): self
    {
        $this->Attendant_id->removeElement($attendantId);

        return $this;
    }
}
