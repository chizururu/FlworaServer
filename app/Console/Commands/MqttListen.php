<?php

namespace App\Console\Commands;

use App\Events\DeviceStatusEvent;
use App\Events\SensorUpdateEvent;
use App\Models\Device;
use App\Models\Measurement;
use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;

class MqttListen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mqtt-listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $mqtt = MQTT::connection();

        // 1) Sensor data
        $mqtt->subscribe('sensors/+/data', function ($topic, $data) {
            preg_match('/device\/(\d+)\/sensor/', $topic, $m);
            $deviceId = (int)$m[1];

            Measurement::create([
                'device_id' => $deviceId,
                'soil_moisture' => $data['soil_moisture'] ?? null,
                'temperature' => $data['temperature'] ?? null,
                'humidity' => $data['humidity'] ?? null,
            ]);

            event(new SensorUpdateEvent($deviceId, $data));
        });

        // 2) Device status
        $mqtt->subscribe('devices/+/status', function ($topic, $message) {
            preg_match('/device\/(\d+)\/status/', $topic, $m);
            $deviceId = (int)$m[1];

            // Update device status
            $device = Device::findOrFail($deviceId);
            $device->update([
                'is_online' => $message['is_online'] ?? $device->is_online
            ]);

            event(new DeviceStatusEvent($device));
        });
    }

    protected function handleSensor(int $deviceId, array $data): void
    {

    }
}
