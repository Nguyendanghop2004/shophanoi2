@extends('client.layouts.master')
@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection
@section('content')
<section class="flat-spacing-11">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Thanh toán thành công</h2>
                <p>Cảm ơn bạn đã mua hàng. Thông tin thanh toán của bạn như sau:</p>
                <ul>
                    <li><strong>Số tiền:</strong> {{ number_format($data['vnp_Amount'] / 100, 0, ',', '.') }} VND</li>
                    <li><strong>Mã ngân hàng:</strong> {{ $data['vnp_BankCode'] }}</li>
                    <li><strong>Số giao dịch ngân hàng:</strong> {{ $data['vnp_BankTranNo'] }}</li>
                    <li><strong>Loại thẻ:</strong> {{ $data['vnp_CardType'] }}</li>
                    <li><strong>Thông tin đơn hàng:</strong> {{ $data['vnp_OrderInfo'] }}</li>
                    <li><strong>Ngày thanh toán:</strong> {{ \Carbon\Carbon::createFromFormat('YmdHis', $data['vnp_PayDate'])->format('d/m/Y H:i:s') }}</li>
                    <li><strong>Mã giao dịch VNPay:</strong> {{ $data['vnp_TransactionNo'] }}</li>
                    <li><strong>Trạng thái giao dịch:</strong> {{ $data['vnp_TransactionStatus'] == '00' ? 'Thành công' : 'Thất bại' }}</li>
                    <li><strong>Thành phố:</strong> {{ $data['city_id'] ?? 'Chưa có thông tin' }}</li>
                    <li><strong>Quận/Huyện:</strong> {{ $data['province_name'] ?? 'Chưa có thông tin' }}</li>
                    <li><strong>Xã/Phường:</strong> {{ $data['wards_name'] ?? 'Chưa có thông tin' }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
