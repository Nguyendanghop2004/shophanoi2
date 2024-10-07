@extends('admin.layouts.master')

@section('content')

    <div class="container">
        <h1 class="mt-5">Liên Hệ</h1>
    

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST" class="p-4 border rounded shadow-sm">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Tên:</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                @error('name')
                    <div class="text-danger">Bạn cần nhập tên</div>
                @enderror
            </div>
        
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <div class="text-danger">
                        Bạn cần nhập email
                    </div>
                @enderror
            </div>
        
            <div class="mb-3">
                <label for="phone" class="form-label">Số điện thoại (tùy chọn):</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                @error('phone')
                    <div class="text-danger">
                        Bạn cần nhập số điện thoại
                    </div>
                @enderror
            </div>
        
            <div class="mb-3">
                <label for="message" class="form-label">Nội dung :</label>
                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="4">{{ old('message') }}</textarea>
                @error('message')
                    <div class="text-danger">
                        Bạn cần nhập nội dung
                    </div>
                @enderror
            </div>
        
            <button type="submit" class="btn btn-primary">Gửi liên hệ</button>
        </form>                        
    </div>

    <hr>

    <div class="card card- mt-5">
        <div class="card-header">
            <h4>Danh Sách Liên Hệ</h4>
        </div>
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="section-title mt-0">
                    Danh sach lien he
                </div>
                <div class="card-header-action">
                    <form class="form-inline">
                        <div class="search-element">
                            <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                                   data-width="250">
                            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên</th>
                                <th scope="col">Email</th>
                                <th scope="col">Số điện thoại</th>
                                <th scope="col">Tin nhắn</th>
                                <th scope="col">Thời gian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($messages as $index => $message)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $message->name }}</td>
                                    <td>{{ $message->email }}</td>
                                    <td>{{ $message->phone ?? 'Không có' }}</td>
                                    <td>{{ $message->message }}</td>
                                    <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-body mx-auto">
            <div class="buttons">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">«</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">»</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>    
@endsection
