@extends('web.admin.app')
@section('title', 'users')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">ALL Users</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div>
        <h1 class="text-center m-3">{{ $user->name }}</h1>
        <img style="max-height: 400px" src="{{ get_file_url($user->image) }}" class="rounded mx-auto d-block"
            alt="Image">
        <div class="card-body">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-secondary m-3">Edit User</a>
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline m-3">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete User</button>
            </form>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>الاسم:</strong> {{ $user->name }}</li>
                <li class="list-group-item"><strong>البريد الإلكتروني:</strong> {{ $user->email }}</li>
                <li class="list-group-item"><strong>الوصف:</strong> {{ $user->bio }}</li>
                <li class="list-group-item"><strong>تاريخ الإنشاء:</strong> {{ $user->created_at }}</li>
                <li class="list-group-item"><strong>تاريخ التحديث:</strong> {{ $user->updated_at }}</li>
            </ul>
        </div>
    </div>


@endsection
