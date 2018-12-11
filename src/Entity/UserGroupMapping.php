<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserGroupMappingRepository")
 * @ORM\Table(name="UserGroupMapping")
 */
class UserGroupMapping
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", name="uId")
     */
    private $uId;

    /**
     * @ORM\Column(type="integer", name="gId")
     */
    private $gId;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="dtCreation")
     */
    private $dtCreation;

    public function __construct()
    {
        $this->dtCreation = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUId(): ?int
    {
        return $this->uId;
    }

    public function setUId(int $uId): self
    {
        $this->uId = $uId;

        return $this;
    }

    public function getGId(): ?int
    {
        return $this->gId;
    }

    public function setGId(int $gId): self
    {
        $this->gId = $gId;

        return $this;
    }

    public function getDtCreation(): ?\DateTimeInterface
    {
        return $this->dtCreation;
    }

    public function setDtCreation(\DateTimeInterface $dtCreation): self
    {
        $this->dtCreation = $dtCreation;

        return $this;
    }
}
