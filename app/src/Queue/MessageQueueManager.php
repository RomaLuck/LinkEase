<?php

namespace Src\Queue;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;
use Src\LoggerFactory;

class MessageQueueManager
{
    private LoggerInterface $logger;

    public function __construct()
    {
        $this->logger = (new LoggerFactory())->getLogger('queue');
    }

    /**
     * @throws \Exception
     */
    public function connect(): AMQPStreamConnection
    {
        return new AMQPStreamConnection(
            $_ENV['AMQP_HOST'],
            $_ENV['AMQP_PORT'],
            $_ENV['AMQP_USER'],
            $_ENV['AMQP_PASSWORD']
        );
    }

    /**
     * @throws \Exception
     */
    public function enqueue($object, string $queueName = 'messages'): void
    {
        $connection = $this->connect();
        $channel = $connection->channel();
        $channel->queue_declare($queueName, false, false, false, false);

        $serializedObject = serialize($object);
        $msq = new AMQPMessage($serializedObject);
        $channel->basic_publish($msq, '', $queueName);

        $this->logger->info('[x] Sent message!');

        $channel->close();
        $connection->close();

    }

    /**
     * @throws \Exception
     */
    public function dequeue($queueName = 'messages'): void
    {
        $connection = $this->connect();
        $channel = $connection->channel();
        $channel->queue_declare($queueName, false, false, false, false);

        $this->logger->info('[*] Waiting for messages. To exit press CTRL+C');

        $callback = function ($msg) {
            if (is_string($msg->body)) {
                $message = unserialize($msg->body, ['allowed_classes' => true]);
                if (is_object($message)) {
                    $message->execute();
                    $this->logger->info('[x] Received');
                } else {
                    $this->logger->info('[x] Received a message that could not be unserialized to an object');
                }
            } else {
                $this->logger->info('[x] Received a non-string message');
            }
        };

        $channel->basic_consume($queueName, '', false, true, false, false, $callback);

        try {
            $channel->consume();
        } catch (\Throwable $exception) {
            $this->logger->info($exception->getMessage());
        }

        $channel->close();
        $connection->close();
    }
}