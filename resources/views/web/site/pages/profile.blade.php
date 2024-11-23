@extends('web.site.app')
@section('title', 'Profile')
@push('style')
    <style>
        .card {
            background-color: #343a40;
            border: 1px solid #495057;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 70%;
            margin: auto;
        }

        .card-body {
            padding: 20px;
        }

        .container {
            padding-left: 15px;
            padding-right: 15px;
        }

        .posts .card {
            margin-bottom: 20px;
        }

        textarea.form-control {
            resize: none;
            padding: 10px;
        }

        button {
            margin-top: 10px;
        }

        #loading {
            text-align: center;
            display: none;
        }

        .comment-box {
            margin-top: 15px;
        }

        .comment-box textarea {
            width: 100%;
            height: 60px;
            margin-bottom: 10px;
        }
    </style>
@endpush
@section('content')
    <div class="container my-5">
        <div class="card bg-dark text-white mb-4">
            <div class="card-body text-center">
                <img src="{{ get_file_url($user->image) }}" alt="User Profile" class="rounded-circle mb-3"
                    style="width: 150px; height: 150px;">

                @php
                    $id = auth()->id();
                    $friends1 = $friends->pluck('user_id')->toArray();
                    $friends2 = $friends->pluck('friend_id')->toArray();

                    $pending_user = DB::table('connections')
                        ->where([['user_id', '=', $id], ['friend_id', '=', $user->id], ['status', '=', 'pending']])
                        ->orWhere([['user_id', '=', $user->id], ['friend_id', '=', $id], ['status', '=', 'pending']]);
                    $pending_user = $pending_user->first();
                    if ($pending_user) {
                        $all_friends = array_merge($friends1, $friends2, [
                            $pending_user->user_id,
                            $pending_user->friend_id,
                        ]);
                    } else {
                        $all_friends = array_merge($friends1, $friends2);
                    }
                @endphp

                @if ($user->id !== $id && !in_array($id, $all_friends))
                    <form action="{{ route('site.connections.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="friend_id" value="{{ $user->id }}">
                        <button class="btn btn-primary btn-sm">Send Friend Request</button>
                    </form>
                @endif
                <h3 class="mb-2">{{ $user->name }}</h3>
                <p class="text-white">{{ $user->bio }}</p>
                <p class="text-white">Friends: <span class="text-white">{{ $friends->count() }}</span></p>
            </div>
        </div>

        <!-- صندوق إنشاء بوست جديد -->
        @if ($user->id == auth()->id())
            <div class="card text-white mb-4">
                @include('web.inc.errors')
                <div class="card-body">
                    <h5 class="card-title">Create a New Post</h5>
                    <form action="{{ route('site.post.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <textarea name="content" class="form-control bg-dark text-white" rows="3" placeholder="What's on your mind?"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="postImage" class="form-label">Upload an image (optional):</label>
                            <input name="image" class="form-control bg-dark text-white" type="file" id="postImage"
                                accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </form>
                </div>
            </div>
        @endif

        <!-- منشورات الأصدقاء -->
        <div class="friend-posts">
            @forelse ($posts as $post)
                <div class="card text-white mb-3">
                    <div class="card-body">
                        @if ($user->id == auth()->id())
                            <form action="{{ route('site.post.destroy', $post->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button
                                    style="background: none; border: none; position: absolute; top: 8px; right: 10px; text-decoration: none; font-size: 1.5rem; color: #000;"
                                    type="submit" class="close-btn">&times;</button>
                            </form>
                            <a style="text-decoration: none; position: absolute; top: 20px; right: 40px; text-decoration: none; font-size: 1.5rem; color: #000;"
                                class="close-btn" href="{{ route('site.post.edit', $post->id) }}">⚙️</a>
                        @endif
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ get_file_url($user->image) }}" alt="User" style="width: 50px; height: 50px;"
                                class="rounded-circle me-3">
                            <div>
                                <h6 class="mb-0">{{ $user->name }}</h6>
                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <a style="text-decoration: none" href="{{ route('site.post', ['post_id' => $post->id]) }}">
                            <p class="card-text text-white">{{ $post->content }}</p>
                        </a>
                        @if ($post->image)
                            <a style="text-decoration: none" href="{{ route('site.post', ['post_id' => $post->id]) }}">
                                <img src="{{ get_file_url($post->image) }}" alt="Post Image"
                                    class="img-fluid rounded mb-3">
                            </a>
                        @endif
                        <div class="d-flex">
                            <a style="text-decoration: none" href="{{ route('site.post', ['post_id' => $post->id]) }}">
                                @if (in_array(auth()->id(), $post->likes->pluck('user_id')->toArray()))
                                    <button
                                        class="btn btn-primary btn-sm btn-outline-light me-2">Like({{ $post->likes->count() }})</button>
                                @else
                                    <button
                                        class="btn btn-sm btn-outline-light me-2">Like({{ $post->likes->count() }})</button>
                                @endif

                                <button
                                    class="btn btn-sm btn-outline-light">Comment({{ $post->comments->count() }})</button>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card text-white text-center mb-4">
                    <h3 class="text-white m-3">No posts yet!</h3>
                </div>
            @endforelse
        </div>
    </div>
@endsection
