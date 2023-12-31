<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Поле не должно быть пустым')]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'Минимальное количество символов {{ limit }}',
        maxMessage: 'Максимальное количество символов {{ limit }}',
    )]
    private ?string $title = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: 'Поле не должно быть пустым')]
    #[Assert\Length(
        max: 500,
        maxMessage: 'Ограничение на количество символов. Максимум {{ limit }}.',
    )]
    private ?string $preview = null;

    #[ORM\Column(length: 1000)]
    #[Assert\NotBlank(message: 'Поле не должно быть пустым')]
    #[Assert\Length(
        max: 1000,
        maxMessage: 'Ограничение на количество символов. Максимум {{ limit }}.',
    )]
    private ?string $text = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    private ?int $views = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPreview(): ?string
    {
        return $this->preview;
    }

    public function setPreview(string $preview): static
    {
        $this->preview = $preview;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(?int $views): static
    {
        $this->views = $views;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }
}
