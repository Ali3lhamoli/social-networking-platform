@extends('web.admin.app')
@section('title', 'users')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create New User</h1>
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

    @include('web.inc.errors')
    <div class="card card-primary">
        <!-- form start -->
        <form action="{{route('admin.users.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{old('name')}}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" id="email" value="{{old('email')}}">
                </div>
                <div class="form-group">
                    <label for="bio">bio</label>
                    <input type="text" name="bio" class="form-control" id="bio" value="{{old('bio')}}">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" name="password" class="form-control" id="password" value="{{old('password')}}">
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input name="image" type="file" class="custom-file-input" id="image">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                      <div class="form-check">
                        <input class="form-check-input" name="is_admin" type="radio" value="1" id="admin">
                        <label class="form-check-label" for="admin">
                          admin
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" name="is_admin" type="radio" value="0" id="user">
                        <label class="form-check-label" for="user">
                          user
                        </label>
                      </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>


@endsection
