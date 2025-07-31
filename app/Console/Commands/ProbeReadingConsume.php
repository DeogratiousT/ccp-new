<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RabbitMQService;
use App\Events\ProbeReadingsReceived;

class ProbeReadingConsume extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'probe-reading:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume Probe updates from RabbitMQ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $mqService = new RabbitMQService();

            $mqService->setCallback(function($msg) {
                logger('Raw message body: ' . $msg);

                $data = json_decode($msg, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    logger('Invalid JSON: ' . json_last_error_msg());
                    return;
                }

                if (is_array($data)) {
                    // If it's a list (numeric array) and has index 0
                    if (array_key_exists(0, $data)) {
                        $message = $data[0];
                    } else {
                        // Otherwise treat the whole array as the message
                        $message = $data;
                    }

                    logger('Processed message: ' . json_encode($message));

                    // Dispatch event here if needed
                    // ProbeReadingsReceived::dispatch($message);
                } else {
                    logger('Unexpected message format: ' . var_export($data, true));
                }
            });

            $mqService->consume();  
        } catch (\Throwable $th) {
            logger('Consumer error: ' . $th->getMessage());
        }      
    }
}
