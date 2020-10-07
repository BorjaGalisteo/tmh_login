<?php

namespace App\Infrastructure\Models;

use App\Repository\CodeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CodeRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Code
{


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $verificationCode;

    /**
     * @ORM\Column(type="boolean")
     */
    private $used;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getVerificationCode(): ?string
    {
        return $this->verificationCode;
    }

    public function setVerificationCode(string $verificationCode): self
    {
        $this->verificationCode = $verificationCode;

        return $this;
    }

    public function getUsed(): ?bool
    {
        return $this->used;
    }

    public function setUsed(bool $used): self
    {
        $this->used = $used;

        return $this;
    }

    /**
     * @return mixed
     */
    public function createdAt()
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function updatedAt()
    {
        return $this->updatedAt;
    }

    /**
       * @ORM\PrePersist
       */
      public function setCreatedAtValue()
      {
          $this->createdAt = new \DateTime();
      }

      /**
       * @ORM\PreUpdate
       */
      public function setUpdateAtValue()
      {
          $this->updatedAt = new \DateTime();
      }
}
