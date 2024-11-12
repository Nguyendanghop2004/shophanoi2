@extends('client.layouts.master')

@section('content')
    @include('client.layouts.particals.page-title')
    <!-- page-cart -->
    <section class="flat-spacing-11">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <ul class="my-account-nav">
                        <li><a href="#" data-url="{{ route('account', ['section' => 'dashboard']) }}"
                                class="my-account-nav-item {{ $section == 'dashboard' ? 'active' : '' }}">Dashboard</a></li>
                        <li><a href="#" data-url="{{ route('account', ['section' => 'orders']) }}"
                                class="my-account-nav-item {{ $section == 'orders' ? 'active' : '' }}">Orders</a></li>

                    </ul>
                </div>
                <div class="col-md-9" id="content-area">
                    @if ($section == 'orders')
                        @include('client.layouts.particals.account.orders')
                    @else
                        @include('client.layouts.particals.account.dashboard')
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- page-cart -->
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            var section = new URLSearchParams(window.location.search).get('section');

            if (section === 'orders' || section === 'dashboard') {

                var url = '{{ url('/account') }}/' + section;

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        $('#content-area').html(response);
                    },
                    error: function(xhr) {
                        alert('An error occurred: ' + xhr.status + ' ' + xhr.statusText);
                    }
                });
            }

            $('.my-account-nav a').on('click', function(e) {
                e.preventDefault();
                var url = $(this).data('url');

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {

                        $('#content-area').html(response);

                        window.history.pushState({
                            path: url
                        }, '', url);
                    },
                    error: function(xhr) {
                        alert('An error occurred: ' + xhr.status + ' ' + xhr.statusText);
                    }
                });
            });

            window.onpopstate = function(event) {
                if (event.state) {
                    $.ajax({
                        url: window.location.pathname,
                        method: 'GET',
                        success: function(response) {
                            $('#content-area').html(response);
                        },
                        error: function(xhr) {
                            alert('An error occurred: ' + xhr.status + ' ' + xhr.statusText);
                        }
                    });
                }
            };
        });
    </script>
@endpush
