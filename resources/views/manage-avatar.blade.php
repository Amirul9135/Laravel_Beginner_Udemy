<x-layout>
    <div class="container container--narrow py-md-5">
        <h2>Upload new avatar</h2>
        <form action="profile/{{ $user->id }}/avatar" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <input type="file" name="avatar" required></input>
                @error('avatar')
                    <p class="alert small alert-danger shadow-sm"> {{ $message }}</p>
                @enderror
            </div>
            <button class="btn btn-primary">Save</button>
        </form>
    </div>
</x-layout>
