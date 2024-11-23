@extends('web.site.app')
@section('title', 'Login')
@section('content')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fw-bold my-4 h4">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('site.home') }}">Home ></a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">login</li>
            </ol>
        </nav>
        <div class="d-flex flex-column gap-3 account-form  mx-auto mt-5">
            @include('web.inc.errors')
            <form action="{{route('site.login.authenticate')}}" method="POST" class="form">
                @csrf
                <div class="mb-3">
                    <label class="form-label required-label" for="email">Email</label>
                    <input name="email" type="email" class="form-control" id="email">
                </div>
                <div class="mb-3">
                    <label class="form-label required-label" for="password">password</label>
                    <input name="password" type="password" class="form-control" id="password">
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <div class="d-flex justify-content-center gap-2 flex-column flex-lg-row flex-md-row flex-sm-column">
                <span>don't have an account?</span><a class="link" href="{{ route('site.register.show') }}">create account</a>
            </div>
        </div>

    </div>
@endsection
