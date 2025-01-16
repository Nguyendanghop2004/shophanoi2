<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

  
    public $product_id;
    public $color_id;
    public $size_id;
    public $action; // Hành động: 'update' hoặc 'delete'

    public function __construct($product_id,$color_id,$size_id, $action)
    {
        $this->product_id = $product_id;
        $this->color_id = $color_id;
        $this->size_id = $size_id;
        $this->action = $action;
    }

    public function broadcastOn()
    {
        return new Channel('products'); // Phát trên kênh 'products'
    }

}
