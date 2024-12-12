@extends('web.admin.app')
@section('title', 'users')
@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ALL Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">ALL Posts</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    @include('web.inc.success')
    <div class="container my-5">
        <div id="post-container" class="friend-posts">
            @foreach ($posts as $post)
                <div class="card mb-3">
                    <div class="card-body">
                        <a style="text-decoration: none" href="{{ route('admin.users.show', $post->user->id) }}">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ get_file_url($post->user->image) }}" alt="User"
                                    style="width: 50px; height: 50px;" class="rounded-circle me-3">
                                <div>
                                    <h6 class="mb-0">{{ $post->user->name }}</h6>
                                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </a>
                        <p class="card-text">{{ $post->content }}</p>
                        @if ($post->image)
                            <img src="{{ get_file_url($post->image) }}" alt="Post Image" class="img-fluid rounded mb-3">
                        @endif
                        <div class="d-flex">
                            <button class="btn btn-primary btn-sm btn-outline-light me-2">Like
                                ({{ $post->likes->count() }})
                            </button>

                            <button class="btn btn-primary btn-sm btn-outline-light me-auto">Comment
                                ({{ $post->comments->count() }})</button>

                            <a style="text-decoration: none" href="{{ route('admin.posts.show', $post->id) }}">
                                <button class="btn btn-success btn-sm btn-outline-light me-2">View Post</button>
                            </a>
                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-outline-light">Delete</button>
                            </form>
                        </div>

                    </div>
                </div>
            @endforeach
            <div class="card-footer clearfix">
                {{ $posts->links() }}
            </div>
        </div>
    </div>


@endsection
