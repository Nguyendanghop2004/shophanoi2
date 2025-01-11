@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Lịch sử Update</h1>
        </div>
        
        <div class="row">
            <!-- Người dùng 1 -->
            <div class="col-md-6">

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        {{ $admin->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="card-body">
                        <p><strong>Tên: </strong>{{ $admin->name }}</p>
                        <p><strong>Email: </strong>{{ $admin->email }}</p>
                        <p><strong>Đỉa chỉ: </strong>{{ $admin->address }}</p>
                        <p><strong>Phone: </strong>{{ $admin->phone_number}}</p>
                    </div>
                </div>
                
            </div>

            <!-- Người dùng 2 -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        @foreach ($data->changes as $key => $old)
                            @if ($key == 'created_at')
                                {{ $old }}
                            @endif
                        @endforeach
                    </div>
                    {{-- @dd($data->changes) --}}
                    <div class="card-body">
                        @foreach ($data->changes as $key => $old)
                        {{-- @dd($data->changes) --}}
                            @if ($key == 'name')
                                <p><strong>Tên: </strong>{{ $old }}</p>
                            @endif
                            @if ($key == 'email')
                                <p><strong>Email: </strong> {{ $old }}</p>
                            @endif
                            @if ($key == 'address')
                                <p><strong>Đỉa chỉ: </strong> {{ $old }}</p>
                            @endif
                            @if ($key == 'phone_number')
                                <p><strong>Số điện thoại: </strong> {{ $old }}</p>
                            @endif
                          
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
