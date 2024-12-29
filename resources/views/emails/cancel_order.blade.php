<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chọn lý do hủy đơn hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
            color: #333;
        }

        select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            background-color: #fafafa;
        }

        select:focus {
            border-color: #5c6bc0;
            outline: none;
            background-color: #fff;
        }

        button.cancel-order {
            width: 100%;
            padding: 12px;
            background-color: #f44336;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button.cancel-order:hover {
            background-color: #d32f2f;
        }

        .error-message {
            color: red;
            text-align: center;
            font-size: 14px;
        }

        .success-message {
            color: green;
            text-align: center;
            font-size: 14px;
        }

        .cancel-order-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Chọn lý do hủy đơn hàng {{ $order->order_code }}</h2>

        @if (session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @elseif (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

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

            <div class="cancel-order-wrapper">
                <button type="submit" class="cancel-order">Xác nhận hủy đơn hàng</button>
            </div>
        </form>
    </div>
</body>
</html>
