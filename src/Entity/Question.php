<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1000)
     * @Assert\NotBlank(message="Veuillez saisir votre demande")
     * @Assert\Length(max=1000, maxMessage="Le message peut faire au maximum {{ limit }} caractères")
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank(message="Veuillez définir l'état "vérifié" de la question")
     */
    private $checked = 0;

    /**
     * @ORM\ManyToOne(targetEntity=internaute::class, inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $internauteObject;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getChecked(): ?bool
    {
        return $this->checked;
    }

    public function setChecked(bool $checked): self
    {
        $this->checked = $checked;

        return $this;
    }

    public function getInternauteObject(): ?internaute
    {
        return $this->internauteObject;
    }

    public function setInternauteObject(?internaute $internauteObject): self
    {
        $this->internauteObject = $internauteObject;

        return $this;
    }
}
