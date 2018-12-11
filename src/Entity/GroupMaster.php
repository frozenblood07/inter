<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupMasterRepository")
 * @ORM\Table(name="GroupMaster")
 */
class GroupMaster
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="dtCreation")
     */
    private $dtCreation;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="dtUpdation")
     */
    private $dtUpdation;

    public function __construct()
    {
        $this->dtCreation = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDtCreation(): ?\DateTimeInterface
    {
        return $this->dtCreation;
    }

    public function setDtCreation(?\DateTimeInterface $dtCreation): self
    {
        $this->dtCreation = $dtCreation;

        return $this;
    }

    public function getDtUpdation(): ?\DateTimeInterface
    {
        return $this->dtUpdation;
    }

    public function setDtUpdation(?\DateTimeInterface $dtUpdation): self
    {
        $this->dtUpdation = $dtUpdation;

        return $this;
    }
}
