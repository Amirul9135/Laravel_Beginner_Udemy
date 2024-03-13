<x-profile :profileData="$profileData" :tab="2">
    <div class="list-group"> 
        @foreach ($followers as $follow)
            <!--it is still follow object  --> 
            <a href="/profile/{{ $follow->followingUser->username }}/posts" class="list-group-item list-group-item-action">
                <img class="avatar-tiny" src="{{ $follow->followingUser->avatar }}" />
                <strong>{{ $follow->followingUser->username }}</strong> on {{ $follow->created_at->format('j/n/Y') }}
            </a>
        @endforeach
    </div>
</x-profile>
