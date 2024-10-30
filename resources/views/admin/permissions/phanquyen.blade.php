@extends('admin.layouts.master')

<!-- Select2 CSS -->
<link rel="stylesheet" href="{{ asset('admin/assets/modules/select2/dist/css/select2.min.css') }}">
<script src="{{ asset('admin/assets/modules/select2/dist/js/select2.full.min.js') }}"></script>

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Cấp quyền người dùng: {{ $admin->name }}</h1>
    </div>

    <div class="col-lg-12">
        <a href="{{route('admin.permissions.index')}}" class="btn btn-outline-danger mb-4">Quay lại</a>
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
        @if (session('cancel'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('cancel') }}
        </div>
    @endif

        <div class="card card-primary mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Vai trò hiện tại: @if(isset($name_roles)) {{ $name_roles }} @endif</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form action="{{ url('admin/permissions/insert_permission', [$admin->id]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="permission">Chọn quyền</label>
                            <select class="form-control select2" name="permission[]" multiple="multiple">
                                @foreach ($permission as $per)
                                    <option value="{{ $per->name }}"
                                        @foreach ($get_permission_viaroles as $get)
                                            @if ($get->id == $per->id)
                                                selected
                                            @endif
                                        @endforeach
                                    >
                                        {{ $per->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <input type="submit" name="insertroles" value="Cấp quyền" class="btn btn-danger mt-3">
                    </form>
                </div>
            </div>
        </div>
        
  
    </div>

    <div class="col-lg-12">
        <div class="card card-primary mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Thêm Quyền</h4>
            </div>
            <div class="card-body">
                <form action="{{ url('admin/permissions/insertPermission') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Tên quyền</label>
                        <input type="text" class="form-control" value="{{ old('permission') }}" name="permission" placeholder="Tên quyền">
                    </div>
                    <input type="submit" name="insertper" value="Thêm mới quyền" class="btn btn-danger mt-3">
                </form>
            </div>
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
