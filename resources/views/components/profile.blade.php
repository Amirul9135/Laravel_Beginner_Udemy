<x-layout>


    <div class="container py-md-5 container--narrow">
        <h2>
            <img class="avatar-small" src="{{ $profileData['user']->avatar }}" />
            {{ $profileData['user']->username }}
            @auth
                @if ($profileData['isFollowing'])
                    <form class="ml-2 d-inline" action="/api/follows/{{ $profileData['user']->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Unfollow <i class="fas fa-user-minus"></i></button>
                        <!-- <button class="btn btn-danger btn-sm">Stop Following <i class="fas fa-user-times"></i></button> -->
                    </form>
                @elseif (!$profileData['isFollowing'] and auth()->user()->id != $profileData['user']->id)
                    <form class="ml-2 d-inline" action="/api/follows/{{ $profileData['user']->id }}" method="POST">
                        @csrf
                        <button class="btn btn-primary btn-sm">Follow <i class="fas fa-user-plus"></i></button>
                        <!-- <button class="btn btn-danger btn-sm">Stop Following <i class="fas fa-user-times"></i></button> -->
                    </form>
                @endif

                @if (auth()->user()->id == $profileData['user']->id)
                    <a href="profile/{{ auth()->user()->username }}/avatar/manage" class="btn btn-secondary btn-sm">Manage
                        Avatar</a>
                @endif
            @endauth
        </h2>

        <div class="profile-nav nav nav-tabs pt-2 mb-4">
            <a href="profile/{{ $profileData['user']->username }}/posts"
                class="profile-nav-link nav-item nav-link {{ $tab == 1 ? 'active' : '' }}">Posts:
                {{ $profileData['postCount'] }}</a>
            <a href="profile/{{ $profileData['user']->username }}/followers"
                class="profile-nav-link nav-item nav-link {{ $tab == 2 ? 'active' : '' }}">Followers:
                {{ $profileData['followersCount'] }}</a>
            <a href="profile/{{ $profileData['user']->username }}/followings"
                class="profile-nav-link nav-item nav-link {{ $tab == 3 ? 'active' : '' }}">Following:
                {{ $profileData['followingsCount'] }}</a>
        </div>

        <div class="profile-slot-content">
            {{ $slot }}
        </div>

    </div>


</x-layout>
