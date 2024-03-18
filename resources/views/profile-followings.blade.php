<x-profile :profileData="$profileData" :tab="3">
    <div class="list-group">

        @foreach ($followings as $follow)
            <!--it is still follow object  -->
            <a href="profile/{{ $follow->followedUser->username }}/posts" class="list-group-item list-group-item-action">
                <img class="avatar-tiny" src="{{ $follow->followedUser->avatar }}" />
                <strong>{{ $follow->followedUser->username }}</strong> on {{ $follow->created_at->format('j/n/Y') }}
            </a>
        @endforeach
    </div>
</x-profile>
