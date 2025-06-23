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
                $message = json_decode($msg, true)[0];

                logger('consumer hapa');
                logger($message);

                $location = SensorLocation::where('uuid', $message['probeID'])->firstOrFail();

                $data = [
                    'date' => now()->toDateString(),
                    'time' => now()->toTimeString(),
                    'value' => $message['param'],
                ];
                
                $data['probe_id'] = $location->probe_id;
                $data['sensor_location_id'] = $location->id;
                $data['slug'] = $location->slug;

                ProbeReadingsReceived::dispatch($data);
            });

            $mqService->consume();  
        } catch (\Throwable $th) {
            logger($th->getMessage());
        }      
    }
}
