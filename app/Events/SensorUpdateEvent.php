<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SensorUpdateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $deviceId;
    public array $data;

    /**
     * Create a new event instance.
     */
    public function __construct(int $deviceId, array $data)
    {
        //
        $this->deviceId = $deviceId;
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel("device.{$this->deviceId}");
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */

    public function broadcastWith(): array
    {
        return $this->data;
    }
}
