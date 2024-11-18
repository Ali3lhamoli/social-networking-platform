@extends('web.site.app')
@section('title', 'Settings')
@section('content')
    @push('style')
        <style>
            .card {
                border: 1px solid #495057;
                border-radius: 10px;
                padding: 20px;
            }

            .card h5 {
                font-size: 1.2rem;
                margin-bottom: 20px;
            }
        </style>
    @endpush
    <div class="container my-5">
        <h2 class="text-center text-white mb-4">Settings</h2>

        <div class="row">
            <!-- تعديل الصورة الشخصية -->
            <div class="col-md-6 mb-4">
                <div class="card bg-dark text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">Profile Picture</h5>
                        <img src="{{ Auth::user()->profile_image ?? 'https://via.placeholder.com/150' }}"
                            alt="Profile Picture" class="rounded-circle mb-3" style="width: 150px; height: 150px;">
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input type="file" class="form-control bg-dark text-white" name="profile_image"
                                    accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Update Picture</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- إعدادات الحساب -->
            <div class="col-md-6 mb-4">
                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <h5 class="card-title">Account Settings</h5>
                        <form action="" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control bg-dark text-white" id="username" name="username"
                                    value="">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control bg-dark text-white" id="email" name="email"
                                    value="">
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- إعدادات الأمان -->
        <div class="card bg-dark text-white">
            <div class="card-body">
                <h5 class="card-title">Security Settings</h5>
                <form action="" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control bg-dark text-white" id="currentPassword"
                            name="current_password">
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control bg-dark text-white" id="newPassword" name="new_password">
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control bg-dark text-white" id="confirmPassword"
                            name="confirm_password">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
            </div>
        </div>
    </div>
@endsection
