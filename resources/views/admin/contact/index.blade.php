@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Sách Liên Hệ</h1>
    </div>
    <div class="card card-primary">
        <div class="card-header">
            <h4>Danh Sách Liên Hệ</h4>
            <div class="card-header-action">
                <form class="form-inline" action="{{ route('admin.contact.index') }}" method="GET">
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
                    <ul class="pagination justify-content-center">
                        @if ($contacts->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link" aria-label="Previous">
                                    <span aria-hidden="true">«</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $contacts->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">«</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                        @endif
        
                        @for ($i = 1; $i <= $contacts->lastPage(); $i++)
                            <li class="page-item {{ $i == $contacts->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $contacts->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
        
                        @if ($contacts->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $contacts->nextPageUrl() }}" aria-label="Next">
                                    <span aria-hidden="true">»</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <a class="page-link" aria-label="Next">
                                    <span aria-hidden="true">»</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>    
</section>
@endsection
