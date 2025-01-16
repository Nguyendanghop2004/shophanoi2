<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Log;

class SaleUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $sale;    // Dữ liệu sản phẩm giảm giá
    public $action;  // Loại hành động: create, update, delete

    public function __construct($sale, $action)
    {
        $this->sale = $sale;
        $this->action = $action;
    }

    public function broadcastOn()
    {
        return new Channel('sales'); // Channel chung
    }

    public function broadcastWith()
    {
        return [
            'sale' => $this->sale,
            'action' => $this->action,
        ];
    }
}


