<x-profile :profileData="$profileData" :tab="1">
    <div class="list-group">
        @foreach ($posts as $post)
            <a href="/api/posts/{{ $post->id }}" class="list-group-item list-group-item-action">
                <img class="avatar-tiny" src="{{ $post->postedBy->avatar }}" />
                <strong>{{ $post->title }}</strong> on {{ $post->created_at->format('j/n/Y') }}
            </a>
        @endforeach

    </div>
</x-profile>
