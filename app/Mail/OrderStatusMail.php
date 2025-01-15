<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $message;

    public function __construct($order)
    {
        $this->order = $order;
   
    }

    public function build()
    {
        return $this->subject('Cập nhật trạng thái đơn hàng')
                    ->view('emails.order_status')
                    ->with([
                        'order' => $this->order,
                      
                    ]);
    }
}
