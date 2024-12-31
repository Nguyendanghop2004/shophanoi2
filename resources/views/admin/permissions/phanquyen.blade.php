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
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-danger mb-4">Quay lại</a>

        <!-- Display session messages -->

        <div class="card card-primary mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Vai trò hiện tại: @if(isset($name_roles)) {{ $name_roles }} @endif</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form action="{{ url('admin/permissions/insert_permission', [$admin->id]) }}" method="POST" id="assign-permission-form">
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

                        <input type="submit" name="insertroles" value="Cấp quyền" class="btn btn-danger mt-3" id="assign-permission-btn">
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
            
                <form action="{{ url('admin/permissions/insertPermission') }}" method="POST" id="insert-permission-form">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Tên quyền</label>
                        <input type="text" class="form-control" value="{{ old('permission') }}" name="permission" placeholder="Tên quyền">
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
                    </div>
                    <input type="submit" name="insertper" value="Thêm mới quyền" class="btn btn-danger mt-3" id="add-permission-btn">
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        
        $('.select2').select2();

      
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3000);

    
        $('#assign-permission-btn').click(function(e) {
            e.preventDefault(); 

            Swal.fire({
                title: 'Bạn có muốn cấp quyền này cho người dùng?',
                text: "Quyền sẽ được cấp ngay sau khi bạn xác nhận!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có, cấp quyền!',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                
                    $('#assign-permission-form').submit();
                }
            });
        });

       
        $('#add-permission-btn').click(function(e) {
            e.preventDefault(); 

            Swal.fire({
                title: 'Bạn có muốn thêm quyền mới?',
                text: "Quyền này sẽ được thêm vào hệ thống ngay sau khi bạn xác nhận!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có, thêm quyền!',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                   
                    $('#insert-permission-form').submit();
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
