<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client extends BaseModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[Assert\Range(min: 18, max: 60)]
    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[Assert\Range(min: 18, max: 60)]
    #[ORM\Column]
    private ?int $age = null;

    #[ORM\Column(length: 9)]
    private ?string $ssn = null;

    #[Assert\NotBlank]
    #[Assert\Choice(choices: ['CA', 'NY', 'NV'], message: "Credits are available only in CA, NY, and NV.")]
    #[ORM\Column]
    private ?string $address = null;

    #[ORM\Column]
    private ?int $ficoScore = null;

    #[Assert\NotBlank]
    #[Assert\Email]
    #[ORM\Column]
    private ?string $email = null;

    #[Assert\NotBlank]
    #[Assert\Regex("/^\+1\d{10}$/")]
    #[ORM\Column]
    private ?string $phoneNumber = null;

    /**
     * @var Collection<int, Credit>
     */
    #[ORM\OneToMany(targetEntity: Credit::class, mappedBy: 'client')]
    private Collection $credits;

    #[Assert\NotBlank]
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $income = null;


    public function __construct()
    {
        $this->credits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getSsn(): ?string
    {
        return $this->ssn;
    }

    public function setSsn(string $ssn): static
    {
        $this->ssn = $ssn;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getFicoScore(): ?int
    {
        return $this->ficoScore;
    }

    public function setFicoScore(int $ficoScore): static
    {
        $this->ficoScore = $ficoScore;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection<int, Credit>
     */
    public function getCredits(): Collection
    {
        return $this->credits;
    }

    public function addCredit(Credit $credit): static
    {
        if (!$this->credits->contains($credit)) {
            $this->credits->add($credit);
            $credit->setClient($this);
        }

        return $this;
    }

    public function removeCredit(Credit $credit): static
    {
        if ($this->credits->removeElement($credit)) {
            // set the owning side to null (unless already changed)
            if ($credit->getClient() === $this) {
                $credit->setClient(null);
            }
        }

        return $this;
    }

    public function getIncome(): ?int
    {
        return $this->income;
    }

    public function setIncome(int $income): static
    {
        $this->income = $income;

        return $this;
    }
}
