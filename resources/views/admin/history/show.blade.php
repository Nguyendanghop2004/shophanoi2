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
                        <p><strong>Name: </strong>{{ $admin->name }}</p>
                        <p><strong>Email: </strong>{{ $admin->email }}</p>
                        <p><strong>Ảnh: </strong></p>
                        <img src="{{ Storage::url($admin->image_path) }}" alt="Ảnh quản trị viên" width="100px"
                            height="px">
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
                    <div class="card-body">
                        @foreach ($data->changes as $key => $old)
                            @if ($key == 'name')
                                <p><strong>Tên:</strong>{{ $old }}</p>
                            @endif
                            @if ($key == 'email')
                                <p><strong>Email:</strong> {{ $old }}</p>
                            @endif
                            @if ($key == 'image_path')
                                <p><strong>Ảnh:</strong>
                                    <img src="{{ Storage::url($old) }}" alt="Ảnh quản trị viên" width="100px"
                                        height="60px">
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
