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

        .friend-posts .card {
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
    </style>
@endpush

@section('content')
    <div class="container my-5">
        <div id="post-container" class="friend-posts">
            @include('web.site.partials.posts', ['posts' => $posts])
        </div>
        <div id="loading">
            <p>Loading...</p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let page = 2;  
        let loading = false;

        function loadMorePosts() {
            if (loading) return;

            loading = true;
            document.getElementById('loading').style.display = 'block';

            fetch(`{{ route('site.posts.fetch') }}?page=${page}`)
                .then(response => response.text())
                .then(html => {
                    const container = document.getElementById('post-container');
                    container.insertAdjacentHTML('beforeend', html);
                    page++;
                    loading = false;
                    document.getElementById('loading').style.display = 'none';
                })
                .catch(() => {
                    loading = false;
                    document.getElementById('loading').style.display = 'none';
                });
        }

        window.addEventListener('scroll', () => {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
                loadMorePosts();
            }
        });
    </script>
@endpush
