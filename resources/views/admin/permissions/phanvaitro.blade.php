@extends('admin.layouts.master')
<!-- Select2 CSS -->
<link rel="stylesheet" href="{{ asset('admin/assets/modules/select2/dist/css/select2.min.css') }}">
<script src="{{ asset('admin/assets/modules/select2/dist/js/select2.full.min.js') }}"></script>

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Phân vai trò Quản trị : {{ $admin->name }}</h1>
    </div>
        <a href="{{route('admin.permissions.index')}}" class="btn btn-outline-danger mb-4"  >Quay lại</a>
    {{-- Hiển thị thông báo lỗi và thành công --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card card-primary">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Chọn vai trò</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('admin/permissions/insert_roles', [$admin->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="role">Vai trò</label>
                    <select class="form-control select2" name="role" {{ $admin->hasRole('admin') ? 'disabled' : '' }}>
                        @foreach ($role as $r)
                            <option value="{{ $r->name }}" {{ isset($all_column_roles) && $r->id == $all_column_roles->id ? 'selected' : '' }}>
                                {{ $r->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <br>
                <input type="submit" name="insertroles" value="Cấp vai trò" class="btn btn-success" {{ $admin->hasRole('admin') ? 'disabled' : '' }}>
            </form>
        </div>
    </div>

    <div class="card card-primary mt-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Thêm Vai trò</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('admin/permissions/insertRoles') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Tên vai trò</label>
                    <input type="text" class="form-control" value="{{ old('roles') }}" name="roles" placeholder="Tên vai trò">
                </div>
                <div class="form-group">
                    <input type="submit" value="Thêm vai trò" class="btn btn-danger">
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2();
        
        // Tự động ẩn thông báo sau 3 giây
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3000);
    });
</script>
@endpush
