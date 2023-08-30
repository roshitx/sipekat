<section class="grid grid-rows-1 justify-center">
    <div class="avatar flex justify-center">
        <div class="w-36 rounded-full">
            @php
            $avatar = $user->avatar ? asset('storage/avatar/' . $user->avatar) : Avatar::create($user->name)->toBase64();
            @endphp
            <img src="{{ $avatar }}" />
        </div>
    </div>
    <h1 class="text-2xl font-bold mt-5 text-center text-black">{{ $user->name }}</h1>
    <p class="text-md font-medium text-center">{{ $user->email }}</p>
    <p class="text-md font-medium text-center">Jenis kelamin: {{ Str::ucfirst($user->gender) }}</p>
    @if(isset($user->bio))
        <div class="flex flex-col gap-1">
            <p class="text-md font-medium text-center">Bio</p>
            <p class="text-md font-bold text-center text-black">{{ $user->bio }}</p>
        </div>
    @endif
</section>
