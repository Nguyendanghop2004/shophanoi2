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
  

    <div class="card card-primary">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Chọn vai trò</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('admin/permissions/insert_roles', [$admin->id]) }}" method="POST" id="assign-role-form">
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
                <input type="submit" name="insertroles" value="Cấp vai trò" class="btn btn-success" id="assign-role-btn" {{ $admin->hasRole('admin') ? 'disabled' : '' }} >
            </form>
        </div>
    </div>

    <div class="card card-primary mt-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Thêm Vai trò</h4>
        </div>
        <div class="card-body">
            @if(session('thong_bao'))
                <div class="alert alert-success">
                    {{ session('thong_bao') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('admin/permissions/insertRoles') }}" method="POST" id="add-role-form">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Tên vai trò</label>
                    <input type="text" class="form-control" value="{{ old('roles') }}" name="roles" placeholder="Tên vai trò">
                </div>
                <div class="form-group">
                    <input type="submit" value="Thêm vai trò" class="btn btn-danger" id="add-role-btn">
                </div>
            </form>
        </div>
    </div>
    
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
        
        // Tự động ẩn thông báo sau 3 giây
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3000);

        // Xác nhận khi nhấn nút "Cấp vai trò"
        $('#assign-role-btn').click(function(e) {
            e.preventDefault(); // Ngừng gửi form mặc định

            Swal.fire({
                title: 'Bạn có chắc chắn muốn cấp vai trò này cho người dùng?',
                text: "Vai trò sẽ được cấp ngay sau khi bạn xác nhận!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có, cấp vai trò!',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Nếu đồng ý, gửi form
                    $('#assign-role-form').submit();
                }
            });
        });

        // Xác nhận khi nhấn nút "Thêm vai trò"
        $('#add-role-btn').click(function(e) {
            e.preventDefault(); // Ngừng gửi form mặc định

            Swal.fire({
                title: 'Bạn có chắc chắn muốn thêm vai trò này?',
                text: "Vai trò sẽ được thêm ngay sau khi bạn xác nhận!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có, thêm vai trò!',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Nếu đồng ý, gửi form
                    $('#add-role-form').submit();
                }
            });
        });
    });
</script>
<script>
     document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @elseif (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif
        });

   
</script>
@endpush
