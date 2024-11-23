@extends('web.site.app')
@section('title', 'Edit Post')
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
            <div class="card text-white mb-4">
                @include('web.inc.errors')
                <div class="card-body">
                    <h5 class="card-title">Edit Post</h5>
                    <form action="{{ route('site.post.update',$post->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <textarea name="content" class="form-control bg-dark text-white" rows="3" placeholder="What's on your mind?">{{old('content',$post->content)}}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="postImage" class="form-label">Upload an image (optional):</label>
                            <input name="image" class="form-control bg-dark text-white" type="file" id="postImage"
                                accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>
                </div>
            </div>
    </div>
@endsection
