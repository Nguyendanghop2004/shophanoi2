@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Gán Shipper cho Đơn Hàng</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Danh Sách Đơn Hàng Cần Gán Shipper</h4>
        </div>
        <div class="card-body">
          

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID Đơn Hàng</th>
                            <th scope="col">Tên Người Mua</th>
                            <th scope="col">Email</th>
                            <th scope="col">Trạng Thái</th>
                            <th scope="col">Giao cho Shipper</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ $order->status }}</td>
                            <td>
                                @if ($errors->has('assigned_shipper_id'))
                                <span class="text-danger">{{ $errors->first('assigned_shipper_id') }}</span>
                                  @endif
                                <form action="{{ route('admin.order.assignShipper', $order->id) }}" method="POST">
                                    @csrf
                                    <select name="assigned_shipper_id" class="form-control">
                                        <option>Chọn Shipper</option>
                                        @foreach ($shippers as $shipper)
                                            <option value="{{ $shipper->id }}">{{ $shipper->name }}</option>
                                        @endforeach
                                        
                                    </select>
                                   
                                    <button type="submit" class="btn btn-primary mt-2">Giao cho Shipper</button>
                                </form>
                              
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<script>
    $(document).ready(function () {
        toastr.options = {
            "closeButton": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
        };

        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    });

   
</script>
@endsection
