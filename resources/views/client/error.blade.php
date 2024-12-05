


<div class="alert alert-danger">
        <strong>Lỗi:</strong> {{ $error }}
    </div>
    @if (!empty($outOfStockItems))
        <h3>Danh sách sản phẩm không đủ số lượng:</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                   
                    <th>Số lượng còn lại</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($outOfStockItems as $item)
                    <tr>
                        <td>{{ $item['product_name'] }}</td>
                        <td>{{ $item['requested_quantity'] }}</td>
                        <td>{{ $item['remaining_quantity'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <a href="{{ route('cart') }}" class="btn btn-primary">Quay lại giỏ hàng</a>

