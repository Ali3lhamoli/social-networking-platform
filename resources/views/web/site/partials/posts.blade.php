@foreach ($posts as $post)
    <div class="card text-white mb-3">
        <div class="card-body">
            <a style="text-decoration: none" href="{{ route('site.profile', ['user_id' => $post->user->id]) }}">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ get_file_url($post->user->image) }}" alt="User" style="width: 50px; height: 50px;"
                        class="rounded-circle me-3">
                    <div>
                        <h6 class="mb-0">{{ $post->user->name }}</h6>
                        <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            </a>
            <a style="text-decoration: none" href="{{ route('site.post', ['post_id' => $post->id]) }}">
                <p class="card-text text-white">{{ $post->content }}</p>
            </a>
            @if ($post->image)
                <a style="text-decoration: none" href="{{ route('site.post', ['post_id' => $post->id]) }}">
                    <img src="{{ get_file_url($post->image) }}" alt="Post Image" class="img-fluid rounded mb-3">
                </a>
            @endif
            <div class="d-flex">
                <a style="text-decoration: none" href="{{ route('site.post', ['post_id' => $post->id]) }}">
                    @if (in_array(auth()->id(), $post->likes->pluck('user_id')->toArray()))
                        <button
                            class="btn btn-primary btn-sm btn-outline-light me-2">Like({{ $post->likes->count() }})</button>
                    @else
                        <button class="btn btn-sm btn-outline-light me-2">Like({{ $post->likes->count() }})</button>
                    @endif <button class="btn btn-sm btn-outline-light">Comment
                        ({{ $post->comments->count() }})</button>
                </a>
            </div>
        </div>
    </div>
@endforeach
