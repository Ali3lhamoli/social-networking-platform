@extends('web.site.app')
@section('title', 'All Friends')
@section('content')
    @push('style')
        <style>
            .card {
                border: 1px solid #495057;
                border-radius: 10px;
            }

            .card img {
                border: 3px solid #6c757d;
            }

            .card h5 {
                font-size: 1.2rem;
                margin-bottom: 10px;
            }
        </style>
    @endpush
    <div class="container my-5">
        <h2 class="text-center text-white mb-4">All Friends</h2>

        <!-- قائمة الأشخاص -->
        <div class="row">
            <!-- مستخدم 1 -->
            <div class="col-md-4 mb-4">
                <div class="card bg-dark text-white">
                    <div class="card-body text-center">
                        <img src="https://via.placeholder.com/100" alt="User" class="rounded-circle mb-3"
                            style="width: 100px; height: 100px;">
                        <h5 class="card-title">John Doe</h5>
                        <button class="btn btn-primary btn-sm">Delete Friend</button>
                    </div>
                </div>
            </div>

            <!-- مستخدم 2 -->
            <div class="col-md-4 mb-4">
                <div class="card bg-dark text-white">
                    <div class="card-body text-center">
                        <img src="https://via.placeholder.com/100" alt="User" class="rounded-circle mb-3"
                            style="width: 100px; height: 100px;">
                        <h5 class="card-title">Jane Smith</h5>
                        <button class="btn btn-primary btn-sm">Send Friend Request</button>
                    </div>
                </div>
            </div>

            <!-- مستخدم 3 -->
            <div class="col-md-4 mb-4">
                <div class="card bg-dark text-white">
                    <div class="card-body text-center">
                        <img src="https://via.placeholder.com/100" alt="User" class="rounded-circle mb-3"
                            style="width: 100px; height: 100px;">
                        <h5 class="card-title">Alice Brown</h5>
                        <button class="btn btn-primary btn-sm">Send Friend Request</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
