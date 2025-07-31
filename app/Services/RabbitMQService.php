<?php

namespace App\Services;

use App\Models\Section;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQService
{
    private $callback;

    public function setCallback($callback)
    {
        $this->callback = $callback;
    }

    public function consume()
    {
        try {
            $connection = new AMQPStreamConnection(
                env('MQ_HOST'),
                env('MQ_PORT'),
                env('MQ_USER'),
                env('MQ_PASS')
            );

            $channel = $connection->channel();

            logger('Connected to RabbitMQ');

            // Load exchanges from database
            $exchanges = [];
            $sections = Section::all();
            foreach ($sections as $section) {
                if ($section->rabbitmq_exchange) {
                    $exchanges[] = $section->rabbitmq_exchange;
                }
            }

            logger('Exchanges: ' . json_encode($exchanges));

            // Set callback
            $callback = function ($msg) {
                if ($this->callback) {
                    call_user_func($this->callback, $msg->body);
                }
            };

            // Declare and bind all queues
            foreach ($exchanges as $exchange) {
                $channel->exchange_declare($exchange, 'direct', false, true, false);
                $channel->queue_declare($exchange, false, true, false, false);
                $channel->queue_bind($exchange, $exchange, $exchange);
                $channel->basic_consume($exchange, '', false, true, false, false, $callback);
                logger("Subscribed to: $exchange");
            }

            echo "Waiting for messages on multiple queues...\n";

            while ($channel->is_consuming()) {
                $channel->wait();
            }

            $channel->close();
            $connection->close();

        } catch (\Exception $e) {
            logger('RabbitMQ connection error: ' . $e->getMessage());
        }
    }
}
