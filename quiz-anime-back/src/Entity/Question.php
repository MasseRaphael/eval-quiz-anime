<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[ApiResource(
    normalizationContext: [ 'groups' => ['read:collections']],
    itemOperations: [
        'get'
    ]
)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:collections'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:collections'])]
    private $Title;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:collections'])]
    private $correctAnswer;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:collections'])]
    private $videosUrl;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Answer::class, orphanRemoval: true)]
    #[Groups(['read:collections'])]
    private $Answers;

    public function __construct()
    {
        $this->Answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getCorrectAnswer(): ?string
    {
        return $this->correctAnswer;
    }

    public function setCorrectAnswer(string $correctAnswer): self
    {
        $this->correctAnswer = $correctAnswer;

        return $this;
    }

    public function getVideosUrl(): ?string
    {
        return $this->videosUrl;
    }

    public function setVideosUrl(string $videosUrl): self
    {
        $this->videosUrl = $videosUrl;

        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->Answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->Answers->contains($answer)) {
            $this->Answers[] = $answer;
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->Answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }
}
