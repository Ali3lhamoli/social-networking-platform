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

    @foreach ($users as $user)
        <div class="col-md-4 mb-4">
            <div class="card bg-dark text-white">
                <div class="card-body text-center">
                    <a style="text-decoration: none"
                        href="{{ route('site.profile', ['user_id' => $user->id]) }}">
                        <img src="{{ get_file_url($user->image) }}" alt="User" class="rounded-circle mb-3"
                            style="width: 100px; height: 100px;">
                        <h5 class="card-title">{{ $user->name }}</h5>
                    </a>
                    <form action="{{route('site.connections.destroy', $user->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-primary btn-sm">Unfriend</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

</div>
<nav class="mt-5" aria-label="navigation">
    <ul class="pagination justify-content-center">
        <div class="card-footer clearfix">
            {{ $users->links() }}
        </div>
    </ul>
</nav>
</div>
@endsection
