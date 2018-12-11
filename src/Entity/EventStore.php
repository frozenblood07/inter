<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventStoreRepository")
 * @ORM\Table(name="EventStore")
 */
class EventStore
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
    private $eventType;

    /**
     * @ORM\Column(type="text")
     */
    private $eventData;

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

    public function getEventType(): ?string
    {
        return $this->eventType;
    }

    public function setEventType(string $eventType): self
    {
        $this->eventType = $eventType;

        return $this;
    }

    public function getEventData(): ?string
    {
        return $this->eventData;
    }

    public function setEventData(string $eventData): self
    {
        $this->eventData = $eventData;

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
