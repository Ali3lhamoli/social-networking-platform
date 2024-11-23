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
        @include('web.inc.errors')


        <div class="row">
            <!-- تعديل الصورة الشخصية -->
            <div class="col-md-6 mb-4">
                <div class="card bg-dark text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">Profile Picture</h5>
                        <img src="{{get_file_url(auth()->user()->image)}}"
                            alt="Profile Picture" class="rounded-circle mb-3" style="width: 150px; height: 150px;">
                        <form action="{{route('site.settings.picture.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <input type="file" class="form-control bg-dark text-white" name="image"
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
                        <form action="{{route('site.settings.account.update')}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control bg-dark text-white" id="username" name="name"
                                    value="{{auth()->user()->name}}">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control bg-dark text-white" id="email" name="email"
                                    value="{{auth()->user()->email}}">
                            </div>
                            <div class="mb-3">
                                <label for="bio" class="form-label">Bio</label>
                                <input type="text" class="form-control bg-dark text-white" id="bio" name="bio"
                                    value="{{auth()->user()->bio}}">
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
                <form action="{{route('site.settings.security.update')}}" method="POST">
                    @csrf
                    @method('Put')
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control bg-dark text-white" id="currentPassword"
                            name="current_password">
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control bg-dark text-white" id="newPassword" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control bg-dark text-white" id="confirmPassword"
                            name="password_confirmation">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
            </div>
        </div>
    </div>
@endsection
