<?php

namespace App\Services;

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQService
{
    private $callback;

    public function setCallback($callback)
    {
        $this->callback = $callback;
    }

    public function publish($message)
    {
        
        $connection = new AMQPStreamConnection(env('MQ_HOST'), env('MQ_PORT'), env('MQ_USER'), env('MQ_PASS'), env('MQ_VHOST'));
        $channel = $connection->channel();
        $channel->exchange_declare('DryerExchange', 'direct', false, false, false);
        $channel->queue_declare('DryerQueue', false, false, false, false);
        $channel->queue_bind('DryerQueue', 'DryerExchange', 'test_key');
        $msg = new AMQPMessage($message);
        $channel->basic_publish($msg, 'DryerExchange', 'test_key');
        logger(" [x] Sent $message to DryerExchange / DryerQueue.\n");
        $channel->close();
        $connection->close();
    }

    // public function consume()
    // {
    //     $connection = new AMQPStreamConnection(env('MQ_HOST'), env('MQ_PORT'), env('MQ_USER'), env('MQ_PASS'), env('MQ_VHOST'));
    //     $channel = $connection->channel();
    //     $callback = function ($msg) {
    //         if ($this->callback) {
    //             call_user_func($this->callback, $msg->body);
    //         }
    //     };
    //     $channel->queue_declare('DryerQueue', false, false, false, false);
    //     $channel->basic_consume('DryerQueue', '', false, false, false, false, $callback);
    //     echo 'Waiting for new message on DryerQueue', " \n";
    //     while ($channel->is_consuming()) {
    //         $channel->wait();
    //     }
    //     $channel->close();
    //     $connection->close();
    // }

    public function consume()
    {
        // $connection = new AMQPStreamConnection(
        //     env('MQ_HOST'),
        //     env('MQ_PORT'),
        //     env('MQ_USER'),
        //     env('MQ_PASS'),
        //     env('MQ_VHOST')
        // );
        $connection = new AMQPStreamConnection(
    env('MQ_HOST'),
    env('MQ_PORT'),
    env('MQ_USER'),
    env('MQ_PASS'),
    env('MQ_VHOST'),
    false,    // insist
    'AMQPLAIN', // login_method
    null,     // login_response
    'en_US',  // locale
    10.0,     // connection_timeout
    60.0,     // read_write_timeout (increase to 60s)
    null,     // context
    false,    // keepalive
    0         // heartbeat
);

        logger('connected');

        $channel = $connection->channel();

        // Define exchanges and their queues
        $exchanges = [
            'DryerExchange' => ['D01', 'D02', 'D03', 'D04', 'D05', 'D06'],
            'CFUExchange'   => ['CFU01', 'CFU02', 'CFU03', 'CFU04', 'CFU05', 'CFU06', 'CFU07', 'CFU08', 'CFU09', 'CFU10'],
        ];

        // Set callback
        $callback = function ($msg) {
            if ($this->callback) {
                call_user_func($this->callback, $msg->body);
            }
        };

        // Declare and bind all queues
        foreach ($exchanges as $exchange => $queues) {
            $channel->exchange_declare($exchange, 'direct', false, true, false);

            foreach ($queues as $queue) {
                $channel->queue_declare($queue, false, true, false, false);
                $channel->queue_bind($queue, $exchange, $queue);
                $channel->basic_consume($queue, '', false, true, false, false, $callback);
            }
        }

        echo "Waiting for messages on multiple queues...\n";

        // Start consuming
        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
}