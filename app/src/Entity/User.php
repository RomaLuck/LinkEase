<?php

namespace Src\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Src\Repository\UserRepository;

#[ORM\Embeddable]
#[ORM\Entity(repositoryClass: UserRepository::class)]
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

    #[ORM\Column(type: 'string')]
    public string $time_zone;

    #[ORM\Column(type: 'string', nullable: true)]
    private string|null $oauth_id;

    #[ORM\Column(type: 'string', nullable: true)]
    private string|null $telegram_chat_id;

    #[ORM\Column(type: 'string', nullable: true)]
    private string|null $image_path;

    #[ORM\Column(type: 'datetime')]
    private DateTime $created_at;

    #[ORM\Column(type: 'string', nullable: true)]
    private string|null $confirmation_token;

    #[ORM\Column(type: 'boolean')]
    private bool $is_email_confirmed;

    #[ORM\OneToOne(mappedBy: 'user')]
    private UserSettings $settings;

    #[ManyToOne(targetEntity: Role::class)]
    #[JoinColumn(name: 'role_id', referencedColumnName: 'id')]
    private Role $role;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->setCreatedAt();
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function setRole(Role $role): self
    {
        $this->role = $role;
        return $this;
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
        $this->created_at = new DateTime();
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

    public function getTimeZone(): string
    {
        return $this->time_zone;
    }

    public function setTimeZone(string $time_zone): self
    {
        $this->time_zone = $time_zone;
        return $this;
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmation_token;
    }

    public function setConfirmationToken(?string $confirmation_token): self
    {
        $this->confirmation_token = $confirmation_token;
        return $this;
    }

    public function isEmailConfirmed(): bool
    {
        return $this->is_email_confirmed;
    }

    public function setIsEmailConfirmed(bool $is_email_confirmed): self
    {
        $this->is_email_confirmed = $is_email_confirmed;
        return $this;
    }
}