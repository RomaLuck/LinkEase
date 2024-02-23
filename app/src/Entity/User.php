<?php

namespace Src\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Src\Repository\UserRepository;

#[ORM\Embeddable]
#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'string')]
    private string $email;

    #[ORM\Column(type: 'string', nullable: true)]
    private string|null $oauth_id;

    #[ORM\Column(type: 'string', nullable: true)]
    private string|null $telegram_chat_id;


    #[ORM\Column(type: 'string', nullable: true)]
    private string|null $image_path;

    #[ORM\Column(type: 'datetime')]
    private DateTime $created_at;

    #[ORM\OneToOne]
    private UserSettings $settings;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->setCreatedAt();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getOauthId(): ?string
    {
        return $this->oauth_id;
    }

    public function setOauthId(?string $oauth_id): self
    {
        $this->oauth_id = $oauth_id;
        return $this;
    }

    public function getTelegramChatId(): ?string
    {
        return $this->telegram_chat_id;
    }

    public function setTelegramChatId(?string $telegram_chat_id): self
    {
        $this->telegram_chat_id = $telegram_chat_id;
        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->image_path;
    }

    public function setImagePath(?string $image_path): self
    {
        $this->image_path = $image_path;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    /**
     * @throws \Exception
     */
    public function setCreatedAt(): self
    {
        $this->created_at = new DateTime('now', new \DateTimeZone('Europe/Warsaw'));
        return $this;
    }

    public function getSettings(): UserSettings
    {
        return $this->settings;
    }

    public function setSettings(UserSettings $settings): self
    {
        $this->settings = $settings;
        return $this;
    }
}