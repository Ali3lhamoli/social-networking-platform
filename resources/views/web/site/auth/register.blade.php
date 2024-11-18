@extends('web.site.app')
@section('title', 'Register')
@section('content')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fw-bold my-4 h4">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{route('site.home')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">login</li>
            </ol>
        </nav>
        <div class="d-flex flex-column gap-3 account-form mx-auto mt-5">
            @include('web.inc.errors')
            <form class="form" action="{{route('site.register.store')}}" method="POST">
                @csrf
                <div class="form-items">
                    <div class="mb-3">
                        <label class="form-label required-label" for="name">Name</label>
                        <input name="name" type="text" class="form-control" id="name" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label required-label" for="phone">Phone</label>
                        <input name="phone" type="tel" class="form-control" id="phone" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label required-label" for="email">Email</label>
                        <input name="email" type="email" class="form-control" id="email" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label required-label" for="password">password</label>
                        <input name="password" type="password" class="form-control" id="password" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label required-label" for="password_confirmation">Confirm Password</label>
                        <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" >
                    </div>
                    <div class="mt-4">
                        <input type="radio" id="doctor" name="role" value="doctor">
                        <label class="form-label required-label" for="doctor">Doctor</label>
                        <br>
                        <input type="radio" id="patient" name="role" value="patient">
                        <label class="form-label required-label" for="patient">Patient</label>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">Create account</button>
            </form>
            <div class="d-flex justify-content-center gap-2">
                <span>already have an account?</span><a class="link" href="{{route('site.login.show')}}"> login</a>
            </div>
        </div>
    </div>
@endsection
