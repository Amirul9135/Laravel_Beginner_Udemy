<x-layout>

    <div class="container py-md-5 container--narrow">
        @unless ($feeds->isEmpty())
            <h2 class="test-center mb-4">Latest posts from your follows</h2>

            <div class="list-group">
                @foreach ($feeds as $post)
                    <a href="/api/posts/{{ $post->id }}" class="list-group-item list-group-item-action">
                        <img class="avatar-tiny" src="{{ $post->postedBy->avatar }}" />
                        <strong>{{ $post->title }}</strong> <span class="test-muted">by {{ $post->postedBy->username }} on
                            {{ $post->created_at->format('j/n/Y') }}</span>
                    </a>
                @endforeach

            </div>
            {{ $feeds->links() }}
        @else
            <div class="text-center">
                <h2>Hello <strong>{{ auth()->user()->username }}</strong>, your feed is empty.</h2>
                <p class="lead text-muted">Your feed displays the latest posts from the people you follow. If you don&rsquo;t
                    have any friends to follow that&rsquo;s okay; you can use the &ldquo;Search&rdquo; feature in the top
                    menu bar to find content written by people with similar interests and then follow them.</p>
            </div>
        @endunless
    </div>

</x-layout>
