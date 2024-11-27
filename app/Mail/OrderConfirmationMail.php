<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Lấy các thông tin chi tiết sản phẩm từ bảng OrderItem và nối với bảng Product
        $orderItems = $this->order->orderItems->map(function ($item) {
            // Nối với bảng Product để lấy tên sản phẩm
            $product = $item->product;
            return [
                'product_name' => $product->product_name,
                'quantity' => $item->quantity,
                'color_name' => $item->color_name,
                'size_name' => $item->size_name,
            ];
        });

        // Lấy tên người nhận từ bảng User
        $userName = $this->order->user ? $this->order->user->name : 'Khách hàng';

        // Trả về email với view và dữ liệu cần thiết
        return $this->subject('Xác Nhận Đơn Hàng')
                    ->view('emails.order_confirmation')
                    ->with([
                        'order' => $this->order,
                        'orderItems' => $orderItems, // Gửi dữ liệu orderItems đã cập nhật vào view
                        'userName' => $userName, // Gửi tên người nhận vào view
                    ]);
    }
}
