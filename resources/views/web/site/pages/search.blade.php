@extends('web.site.app')
@section('title', 'Friends')
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
        <h2 class="text-center text-white mb-4">Find People</h2>

        <!-- قائمة الأشخاص -->
        <div class="row">

            @forelse ($users as $user)
                @if (auth()->id() == $user->id)
                    <div class="col-md-12 text-center">
                        <h5 class="text-white">No more users found</h5>
                    </div>
                    @continue
                @endif
                <div class="col-md-4 mb-4">
                    <div class="card bg-dark text-white">
                        <div class="card-body text-center">
                            <a style="text-decoration: none" href="{{ route('site.profile', ['user_id' => $user->id]) }}">
                                <img src="{{ get_file_url($user->image) }}" alt="User" class="rounded-circle mb-3"
                                    style="width: 100px; height: 100px;">
                                <h5 class="card-title">{{ $user->name }}</h5>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12 text-center">
                    <h5 class="text-white">No users found</h5>
                </div>
            @endforelse

        </div>
    </div>
@endsection
