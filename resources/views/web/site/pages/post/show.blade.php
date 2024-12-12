@extends('web.site.app')
@section('title', 'Home')
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

        .post .card {
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
        <div class="posts">
            @foreach ($posts as $post)
                <div class="card text-white mb-3">
                    <div class="card-body">
                        <a style="text-decoration: none" href="{{ route('site.profile', ['user_id' => $post->user->id]) }}">
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
                            <img src="{{ get_file_url($post->image) }}" alt="Post Image"
                                class="img-fluid rounded mb-3">
                        @endif
                        <div class="d-flex">
                            {{-- {{dd($post->user->id)}} --}}
                            @if (in_array(auth()->id(), $post->likes->pluck('user_id')->toArray()))
                                <form action="{{ route('site.likes.destroy', $post->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <button type="submit" class="btn btn-primary btn-sm btn-outline-light me-2">Like
                                        ({{ $post->likes->count() }})</button>
                                </form>
                            @else
                                <form action="{{ route('site.likes.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <button type="submit" class="btn btn-sm btn-outline-light me-2">Like
                                        ({{ $post->likes->count() }})</button>
                                </form>
                            @endif

                            <button class="btn btn-sm btn-outline-light comment-btn"
                                data-target="#comment-{{ $post->id }}">
                                Comment ({{ $post->comments->count() }})
                            </button>
                        </div>
                        <div class="comment-box" id="comment-{{ $post->id }}">
                            @include('web.inc.errors')
                            <form action="{{ route('site.comments.store') }}" method="POST">
                                @csrf
                                <textarea name="content" class="form-control" placeholder="Write a comment..."></textarea>
                                <input style="display: none" name="post_id" type="text" value="{{ $post->id }}">
                                <button type="submit" class="btn btn-sm btn-primary">Post Comment</button>
                            </form>
                        </div>
                        <div class="comments mt-4">
                            @foreach ($post->comments as $comment)
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <!-- الجزء الأيسر: صورة المستخدم والتعليق -->
                                    <div class="d-flex align-items-center">
                                        <a style="text-decoration: none"
                                            href="{{ route('site.profile', ['user_id' => $comment->user->id]) }}">
                                            <img src="{{ get_file_url($comment->user->image) }}" alt="User"
                                                style="width: 40px; height: 40px;" class="rounded-circle me-3">
                                        </a>
                                        <div>
                                            <a style="text-decoration: none"
                                                href="{{ route('site.profile', ['user_id' => $comment->user->id]) }}">
                                                <h6 class="mb-1 text-white">{{ $comment->user->name }}</h6>
                                            </a>
                                            <p class="mb-0 text-light">{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                    <!-- الجزء الأيمن: أزرار التعديل والحذف -->
                                    <div class="d-flex">
                                        <!-- زر تعديل التعليق -->
                                        @if (auth()->id() === $comment->user->id)
                                            <button class="btn btn-sm btn-outline-warning me-2 edit-comment-btn"
                                                data-id="{{ $comment->id }}" data-content="{{ $comment->content }}"
                                                data-url="{{ route('site.comments.update', $comment->id) }}">
                                                ⚙️
                                            </button>
                                        @endif
                                        @if (auth()->id() === $post->user->id || auth()->id() === $comment->user->id)
                                            <!-- زر حذف التعليق -->
                                            <form action="{{ route('site.comments.destroy', $comment->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    &times;
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    <!-- Modal تعديل التعليق -->
                                    <div class="modal fade" id="editCommentModal" tabindex="-1"
                                        aria-labelledby="editCommentModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editCommentModalLabel">Edit Comment</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editCommentForm" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="commentContent" class="form-label">Edit your
                                                                comment:</label>
                                                            <textarea name="content" id="commentContent" class="form-control" rows="3"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.comment-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.querySelector('textarea').focus();
                    }
                });
            });
        });
        // عند الضغط على زر تعديل التعليق
        document.querySelectorAll('.edit-comment-btn').forEach(button => {
            button.addEventListener('click', function() {
                // الحصول على البيانات من الزر
                const commentId = this.dataset.id;
                const commentContent = this.dataset.content;
                const updateUrl = this.dataset.url;

                // تعبئة الفورم داخل النافذة
                const modalForm = document.getElementById('editCommentForm');
                modalForm.action = updateUrl;
                document.getElementById('commentContent').value = commentContent;

                // فتح النافذة
                const editCommentModal = new bootstrap.Modal(document.getElementById('editCommentModal'));
                editCommentModal.show();
            });
        });
    </script>
@endpush
