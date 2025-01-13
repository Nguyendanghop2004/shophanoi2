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
<<<<<<< HEAD
                   
                    </div>
                </div>

=======
                        <p><strong>Đỉa chỉ: </strong>{{ $admin->address }}</p>
                        <p><strong>Phone: </strong>{{ $admin->phone_number}}</p>
                    </div>
                </div>
                
>>>>>>> 0b5a27032d476e6f147cba32469c5d5c7302d1b5
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
                    <div class="card-body">
                        @foreach ($data->changes as $key => $old)
                        {{-- @dd($data->changes) --}}
                            @if ($key == 'name')
<<<<<<< HEAD
                                <p><strong>Tên:</strong>{{ $old }}</p>
=======
                                <p><strong>Tên: </strong>{{ $old }}</p>
>>>>>>> 0b5a27032d476e6f147cba32469c5d5c7302d1b5
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
<<<<<<< HEAD
                            {{-- @if ($key == 'image_path')
                                <p><strong>Ảnh:</strong>
                                    <img src="{{ Storage::url($old) }}" alt="Ảnh quản trị viên" width="100px"
                                        height="60px">
                            @endif --}}
=======
                          
>>>>>>> 0b5a27032d476e6f147cba32469c5d5c7302d1b5
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
