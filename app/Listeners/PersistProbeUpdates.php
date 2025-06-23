<?php

namespace App\Listeners;

use App\Models\Reading;
use App\Events\ProbeReadingsReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PersistProbeUpdates
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProbeReadingsReceived $event): void
    {
        $data = $event->data;

        Reading::updateOrCreate([
            'probe_id' => $data['probe_id'],
            'sensor_location_id' => $data['sensor_location_id'],
            'date' => $data['date'],
            'time' => $data['time']
        ], [
            'value' => $data['value']
        ]);
    }
}
