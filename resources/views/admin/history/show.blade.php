@extends('admin.layouts.master')

@section('content')
<style>
.card {
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    margin-bottom: 20px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}

.card-header {
    font-size: 1.2rem;
    font-weight: bold;
    padding: 10px 20px;
}

.card-body {
    padding: 20px;
}

.bg-primary {
    background-color: #007bff !important;
}

.bg-success {
    background-color: #28a745 !important;
}

.text-white {
    color: white !important;
}

.card-header span {
    font-weight: normal;
}

section {
    padding: 40px 20px;
}

h1 {
    font-size: 2rem;
    color: #333;
    margin-bottom: 20px;
}

h2 {
    font-size: 1.5rem;
    color: #555;
    margin-bottom: 15px;
}

.row {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .col-md-6 {
        flex: 0 0 100%;
    }
}


</style>
    <section class="section">
        <div class="section-header">
            <h1>Lịch sử Update</h1>
        </div>

        <div class="row">
            
            <!-- Người dùng 1 -->
            <div class="col-md-6">
                <h2>Tài khoản {{ $admin->name }} đã thay đổi thành</h2>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <strong>Cập nhật mới: </strong>{{ $admin->updated_at }}
                    </div>
                    <div class="card-body">
                        <p><strong>Name: </strong>{{ $admin->name }}</p>
                        <p><strong>Email: </strong>{{ $admin->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Người dùng 2 -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <strong>Lịch sử cũ : </strong> 
                        @foreach ($data->changes as $key => $old)
                            @if ($key == 'created_at')
                                <span>{{ $old }}</span>
                            @endif
                        @endforeach
                    </div>
                    <div class="card-body">
                        @foreach ($data->changes as $key => $old)
                            @if ($key == 'name')
                                <p><strong>Tên:</strong> {{ $old }}</p>
                            @endif
                            @if ($key == 'email')
                                <p><strong>Email:</strong> {{ $old }}</p>
                            @endif
                            {{-- Hiển thị hình ảnh nếu có --}}
                            {{-- @if ($key == 'image_path')
                                <p><strong>Ảnh:</strong>
                                    <img src="{{ Storage::url($old) }}" alt="Ảnh quản trị viên" class="img-fluid rounded" style="width: 100px; height: 60px;">
                                </p>
                            @endif --}}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
