@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Lịch sử </h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Danh Sách Quản Trị</h4>
                <div class="card-header-action">

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name update</th>
                                <th scope="col">Chức năng thay đổi</th>
                                <th scope="col"> Id Tài khoản bị thay đổi</th>
                                <th scope="col">updated_at</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($histories as $admin)
                                <tr>
                                    <th scope="row">{{ $admin->id }}</th>
                                    <td> {{ $admin->admin->name }}</td>
                                    <td>{{ $admin->action }}</td>
                                    <td>
                                        {{ $admin->model_id }}
                                    </td>
                                    <td>
                                        {{ $admin->updated_at ->format('d/m/Y H:i') }}
                                    </td>
                                    <td>
                                        <div class="d-flex">

                                            <a href="{{ route('admin.show', $admin->id) }}" class="btn btn-primary">
                                                <i class="fas fa-eye"></i>

                                            </a>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $histories->links() }}
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
@endsection
