<?php

namespace Src\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
#[ORM\Entity]
#[ORM\Table(name: 'user_settings')]
class UserSettings
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\OneToOne(inversedBy: 'settings')]
    private User $user;

    #[ORM\Column(type: 'string')]
    private string $api_request_url;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $time;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getApiRequestUrl(): string
    {
        return $this->api_request_url;
    }

    public function setApiRequestUrl(string $api_request_url): self
    {
        $this->api_request_url = $api_request_url;
        return $this;
    }

    public function getTime(): \DateTime
    {
        return $this->time;
    }

    public function setTime(\DateTime $time): self
    {
        $this->time = $time;
        return $this;
    }
}