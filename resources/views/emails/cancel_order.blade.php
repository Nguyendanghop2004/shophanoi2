<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chọn lý do hủy đơn hàng</title>
    <style>
        /* Các styles cho form hủy đơn */
        .container {
            width: 80%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .cancel-order {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        .cancel-order:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Chọn lý do hủy đơn hàng {{ $order->order_code }}</h2>

        <form action="{{ route('cancel.order') }}" method="POST">
            @csrf
            <input type="hidden" name="order_code" value="{{ $order->order_code }}">

            <label for="reason">Lý do hủy đơn hàng:</label>
            <select name="reason" id="reason" required>
                <option value="không_cần_nữa">Không cần nữa</option>
                <option value="sai_thông_tin">Sai thông tin sản phẩm</option>
                <option value="không_thích">Không thích sản phẩm</option>
                <option value="không_hài_lòng">Không hài lòng với dịch vụ</option>
                <option value="khác">Khác</option>
            </select>
            <br><br>
            <button type="submit" class="cancel-order">Xác nhận hủy đơn hàng</button>
        </form>
    </div>
</body>
</html>
