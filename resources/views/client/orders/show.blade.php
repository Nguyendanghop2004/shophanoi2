
<div class="container">
    <h1>Chi tiết đơn hàng {{ $order->order_code }}</h1>
    <p>Ngày đặt: {{ $order->created_at }}</p>
    <p>Trạng thái: {{ $order->status }}</p>
  

    <h2>Danh sách sản phẩm</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderitems as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
