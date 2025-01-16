<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\DiscountCode;

class DiscountCodeUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $discountCode;
    public $action;

    public function __construct($discountCode, $action)
    {
        $this->discountCode = $discountCode;
        $this->action = $action;
    }

    public function broadcastOn()
    {
        return new Channel('discount-codes');
    }

    public function broadcastAs()
    {
        return 'DiscountCodeUpdated';
    }
    public function broadcastWith()
    {
        return [
            'discountCode' => $this->discountCode,
            'action' => $this->action,
        ];
    }
}
