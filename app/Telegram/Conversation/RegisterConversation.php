<?php

namespace Telegram\Conversation;

use Src\Container;
use Src\Database;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class RegisterConversation extends Conversation
{
    protected ?string $step = 'askEmail';
    protected string $email;

    /**
     * @throws InvalidArgumentException
     */
    public function askEmail(Nutgram $bot): void
    {
        $bot->sendMessage('Enter your email');
        $this->next('checkEmail');
    }

    /**
     * @throws InvalidArgumentException
     * @throws \Exception
     */
    public function checkEmail(Nutgram $bot): void
    {
        $this->email = $bot->message()->text ?? '';
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $bot->sendMessage('Email is not valid');
            $this->askEmail($bot);
        } else {
            $this->updateUser($bot);
        }
    }

    /**
     * @throws \Exception
     * @throws InvalidArgumentException
     */
    public function updateUser(Nutgram $bot): void
    {
        $db = (new Container())->get(Database::class);
        $user = $db->query('select * from users where email = :email', [
            'email' => $this->email
        ])->fetch();

        if ($user) {
            $db->query('UPDATE users SET telegram_chat_id = :chat_id WHERE email = :email', [
                'chat_id' => $bot->chatId(),
                'email' => $this->email
            ]);
            $bot->sendMessage('User is verified');
        } else {
            $bot->sendMessage('Register in the site please');
        }
        $this->end();
    }
}