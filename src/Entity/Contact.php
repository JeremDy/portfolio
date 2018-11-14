<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(
     *      message= "Ce champ ne peut pas être vide.")
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @Assert\Email(
     *    message = "L'adresse mail '{{ value }}' n'est pas valide.",
     *    checkMX = true
     * )
     * @Assert\NotBlank(
     *      message= "Ce champ ne peut pas être vide.")
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @Assert\NotBlank(
     *      message= "Ce champ ne peut pas être vide.")
     * @ORM\Column(type="string", length=255)
     */
    private $subject;

    /**
     * @Assert\NotBlank(
     *      message= "Ce champ ne peut pas être vide.")
     * @ORM\Column(type="text")
     */
    private $message;

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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
