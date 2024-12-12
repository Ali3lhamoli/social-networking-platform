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

    <div class="container my-5">
        <div class="posts">
            <div class="card mb-3">
                <div class="card-body">
                    <a style="text-decoration: none" href="{{ route('admin.users.show', $post->user->id) }}">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ get_file_url($post->user->image) }}" alt="User" style="width: 50px; height: 50px;"
                            class="rounded-circle m-3">
                        <div>
                            <h6 class="mb-0">{{ $post->user->name }}</h6>
                            <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    </a>
                    <p class="card-text m-3 p-3" style="background-color: rgb(249, 249, 250)">{{ $post->content }}</p>
                    @if ($post->image)
                        <img src="{{ get_file_url($post->image) }}" alt="Post Image" class="img-fluid rounded mb-3">
                    @endif
                    <div class="d-flex m-3">

                        <button class="btn btn-primary btn-sm btn-outline-light me-2">
                            Like ({{ $post->likes->count() }})
                        </button>

                        <button class="btn btn-primary btn-sm btn-outline-light me-2">
                            Comment ({{ $post->comments->count() }})
                        </button>
                    </div>
                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="d-inline m-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm btn-outline-light">Delete Post</button>
                    </form>
                    <div class="comments mt-4">
                        @foreach ($post->comments as $comment)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <!-- الجزء الأيسر: صورة المستخدم والتعليق -->
                                <div class="d-flex align-items-center">
                                    <a style="text-decoration: none"
                                        href="{{ route('admin.users.show', $comment->user->id) }}">
                                        <img src="{{ get_file_url($comment->user->image) }}" alt="User"
                                            style="width: 40px; height: 40px;" class="rounded-circle m-3">
                                    </a>
                                    <div>
                                        <a style="text-decoration: none"
                                            href="{{ route('admin.users.show', $comment->user->id) }}">
                                            <h6 class="mb-1">{{ $comment->user->name }}</h6>
                                        </a>
                                        <p class="mb-0">{{ $comment->content }}</p>
                                    </div>
                                </div>
                                <!-- الجزء الأيمن: أزرار التعديل والحذف -->
                                <div class="d-flex">
                                        <!-- زر حذف التعليق -->
                                        <form action="{{ route('site.comments.destroy', $comment->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                &times;
                                            </button>
                                        </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
