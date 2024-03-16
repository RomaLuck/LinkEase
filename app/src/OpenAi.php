<?php

namespace Src;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class OpenAi
{
    private array $prompt = [];
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->setModel('gpt-3.5-turbo-0125');
    }

    public function setSystemMessage(string $systemMessage): self
    {
        $this->prompt['messages'][] = [
            "role" => "system",
            "content" => $systemMessage
        ];

        return $this;
    }

    public function sendMessage(string $message): self
    {
        $this->prompt['messages'][] = [
            'role' => 'user',
            'content' => $message
        ];

        return $this;
    }

    public function setModel(string $model): self
    {
        $this->prompt['model'] = $model;

        return $this;
    }

    public function reply(string $message): self
    {
        $response = $this->sendMessage($message)->getResponse();
        if ($response) {
            $this->prompt['messages'][] = [
                'role' => 'assistant',
                'content' => $response
            ];
        }

        return $this;
    }

    public function getPrompt(): array
    {
        return $this->prompt;
    }

    public function getResponse(): string
    {
        try {
            $responseJson = $this->client->post('https://api.openai.com/v1/chat/completions', [
                RequestOptions::HEADERS => [
                    "Content-Type" => "application/json",
                    "Authorization" => "Bearer " . $_ENV['OPENAI_KEY']
                ],
                RequestOptions::JSON => $this->getPrompt()
            ])->getBody()->getContents();
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }

        try {
            $response = json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            return $e->getMessage();
        }

        return $response['choices'][0]['message']['content'] ?? '';
    }
}