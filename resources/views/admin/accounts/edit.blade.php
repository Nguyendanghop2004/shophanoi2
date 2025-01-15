@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Cập nhật quản trị viên</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Cập nhật quản trị viên</h4>
            </div>
            <div class="card-body">
                <form id="admin-form" action="{{ route('admin.accounts.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                       
                        
                            <div class="form-group">
                                <label for="name">Tên</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}">
                            </div>
                            
                            @if(!$isAdmin)
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" value="">
                                </div>
                          
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại:</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $admin->phone ?? '') }}">
                        </div>
                        @endif
                        <div class="col-lg-6 col-md-6 col-12">
                            <div id="image-preview" class="image-preview mx-auto"
                                @error('image_path') style="border:2px dashed red" @enderror>
                                <img id="image-preview-img" src="{{ Storage::url($admin['image_path']) }}" width="250px"
                                    height="250px" alt="">
                            </div>
                            <div class="form-group text-center mt-2">
                                <label for="image-upload" class="btn btn-secondary">Chọn ảnh</label>
                                <input type="file" name="image_path" id="image-upload" style="display: none;" />
                            </div>
                            @error('image_path')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <button type="submit" id="submit-btn" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      
    document.addEventListener("DOMContentLoaded", function() {
        // Hiển thị thông báo thành công hoặc lỗi
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

        // Thêm sự kiện thay đổi cho input file
        const imageUpload = document.getElementById('image-upload');
        const imagePreviewImg = document.getElementById('image-preview-img');

        imageUpload.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreviewImg.setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });

        // Xác nhận khi nhấn nút Cập nhật
        $('#submit-btn').on('click', function(e) {
            e.preventDefault(); // Ngừng việc gửi form mặc định

            Swal.fire({
                title: 'Bạn có chắc chắn muốn cập nhật thông tin quản trị viên này?',
                text: "Thông tin quản trị viên sẽ được cập nhật ngay sau khi bạn xác nhận!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có, cập nhật!',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Nếu người dùng xác nhận, gửi form
                    $('#admin-form').submit();
                }
            });
        });
    });
</script>

   
@endsection
