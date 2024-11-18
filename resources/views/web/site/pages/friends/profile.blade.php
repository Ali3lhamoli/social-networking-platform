@extends('web.site.app')
@section('title', 'Profile')
@push('style')
    <style>
        .card {
            background-color: #343a40;
            border: 1px solid #495057;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 70%;
            margin: auto;
        }

        .card-body {
            padding: 20px;
        }

        .container {
            padding-left: 15px;
            padding-right: 15px;
        }

        .friend-posts .card {
            margin-bottom: 20px;
        }

        textarea.form-control {
            resize: none;
            padding: 10px;
        }

        button {
            margin-top: 10px;
        }
    </style>
@endpush
@section('content')
    <div class="container my-5">
        <!-- صورة المستخدم والمعلومات الشخصية -->
        <div class="card bg-dark text-white mb-4">
            <div class="card-body text-center">
                <img src="https://via.placeholder.com/150" alt="User Profile" class="rounded-circle mb-3"
                    style="width: 150px; height: 150px;">
                <h3 class="mb-2">John Doe</h3>
                <p class="text-white">Friends: <span class="text-white">120</span></p>
                <button class="btn btn-primary btn-sm">Send Friend Request</button>
            </div>
        </div>

        <!-- منشورات الأصدقاء -->
        <div class="friend-posts">
            <!-- بوست 1 -->
            <div class="card text-white mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://via.placeholder.com/50" alt="User" class="rounded-circle me-3">
                        <div>
                            <h6 class="mb-0">John Doe</h6>
                            <small class="text-muted">5 minutes ago</small>
                        </div>
                    </div>
                    <p class="card-text">This is a static post content for testing. It looks great! Lorem ipsum dolor sit
                        amet consectetur adipisicing elit. Nam, officia placeat quod fugit illo, sapiente quaerat non dolore
                        adipisci distinctio et explicabo, nulla natus error velit blanditiis iusto laborum dolorum?</p>
                    <img src="https://via.placeholder.com/500x500" alt="Post Image" class="img-fluid rounded mb-3">
                    <div class="d-flex">
                        <button class="btn btn-sm btn-outline-light me-2">Like</button>
                        <button class="btn btn-sm btn-outline-light">Comment</button>
                    </div>
                </div>
            </div>

            <!-- بوست 2 -->
            <div class="card text-white mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://via.placeholder.com/50" alt="User" class="rounded-circle me-3">
                        <div>
                            <h6 class="mb-0">Jane Smith</h6>
                            <small class="text-muted">1 hour ago</small>
                        </div>
                    </div>
                    <p class="card-text">Another static post. Modify this content as needed.</p>
                    <img src="https://via.placeholder.com/400x200" alt="Post Image" class="img-fluid rounded mb-3">
                    <div class="d-flex">
                        <button class="btn btn-sm btn-outline-light me-2">Like</button>
                        <button class="btn btn-sm btn-outline-light">Comment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
