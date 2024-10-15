@extends('admin.layouts.master')

@section('content')

    <div class="container">
        <h1 class="mt-5">Liên Hệ</h1>
    

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

    <div class="card card-primary">
        <div class="card-header">
            <h4>Danh Sách Liên Hệ</h4>
            <div class="card-header-action">
                <form class="form-inline" action="{{ route('contact.index') }}" method="GET">
                    <div class="search-element">
                        <input class="form-control" type="search" name="search" placeholder="Tìm kiếm..." value="{{ $search ?? '' }}" aria-label="Search" data-width="250">
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
                        @if($contacts->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center text-danger">Không có liên hệ nào.</td>
                            </tr>
                        @else
                            @foreach($contacts as $contact)
                                <tr>
                                    <th scope="row">{{ $contact->id }}</th>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->phone ?? 'N/A' }}</td>
                                    <td>{{ $contact->message }}</td>
                                    <td>{{ $contact->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-body mx-auto">
            <div class="buttons">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item {{ $contacts->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $contacts->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">«</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>

                        @foreach ($contacts->getUrlRange(1, $contacts->lastPage()) as $page => $url)
                            <li class="page-item {{ $page == $contacts->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ $contacts->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $contacts->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">»</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<script>
    $(document).ready(function () {
        toastr.options = {
            "closeButton": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
        };

        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    });

   
</script>
@endsection
