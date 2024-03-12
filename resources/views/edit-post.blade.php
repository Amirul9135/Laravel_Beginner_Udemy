<x-layout>

    <div class="container py-md-5 container--narrow">
        <form action="/api/posts/{{ $post->id }}" method="POST">
            <p><strong><a href="/api/posts/{{ $post->id }}">Cancel Edit</a></strong></p>
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="post-title" class="text-muted mb-1"><small>Title</small></label>
                <input required name="title" id="post-title" class="form-control form-control-lg form-control-title"
                    type="text" placeholder="" autocomplete="off" value="{{ old('title', $post->title) }}" />
                @error('title')
                    <p class="m-0 small alert alert-danger shadow-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="post-body" class="text-muted mb-1"><small>Body Content</small></label>
                <textarea required name="body" id="post-body" class="body-content tall-textarea form-control" type="text">{{ old('body', $post->body) }}</textarea>
                @error('body')
                    <p class="m-0 small alert alert-danger shadow-sm">{{ $message }}</p>
                @enderror
            </div>

            <button class="btn btn-primary">Save New Post</button>
        </form>
    </div>

</x-layout>
