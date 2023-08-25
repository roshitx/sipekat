<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (Session::has('success'))
            <x-success-alert :message="Session::get('success')" />
            <x-sweetalert :message="Session::get('success')" />
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-12 text-gray-800 overflow-x-auto">
                    <x-button-link-primary class="mb-3" href="{{ route('users.create') }}"><i data-lucide="user-plus"></i>
                        {{ __('Add') }}</x-button-link-primary>

                    <x-button-link-primary class="mb-3 ml-3" href="{{ route('user.export') }}"><i data-lucide="file-up"></i>
                        {{ __('PDF') }}</x-button-link-primary>
                    <div class="overflow-x-auto">
                        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
                            <div class="w-full overflow-x-auto">
                                <table class="w-full whitespace-no-wrap">
                                    <thead>
                                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                            <th class="px-4 py-3">#</th>
                                            <th class="px-4 py-3">Nama</th>
                                            <th class="px-4 py-3">Email</th>
                                            <th class="px-4 py-3">Role</th>
                                            <th class="px-4 py-3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                        @foreach ($users as $user)
                                        <tr class="text-gray-700 dark:text-gray-400">
                                            <th>{{ $loop->iteration }}</th>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center text-sm">
                                                    <!-- Avatar with inset shadow -->
                                                    <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                                        @php
                                                        $avatar = $user->avatar ? asset('storage/avatar/' . $user->avatar) : Avatar::create($user->name)->toBase64()
                                                        @endphp
                                                        <img class="object-cover w-full h-full rounded-full" src="{{ $avatar }}" alt="Profile Image" loading="lazy" />
                                                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold">{{ $user->name }} @if($user->email == Auth::user()->email) <span class="text-secondary text-xs">(You)</span> @endif </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                {{ $user->email }}
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                {{ Str::ucfirst($user->role) }}
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center space-x-4 text-sm">
                                                    <x-button-edit href="{{ Auth::user()->email == $user->email ? route('profile.edit') : route('users.edit', $user->id) }}" class="btn-sm"><i data-lucide="pencil"></i>
                                                    </x-button-edit>
                                                    @if ($user->email != Auth::user()->email)
                                                    @component('dashboard.user.user-delete') @endcomponent
                                                    <x-new-modal :message="'Apakah kamu yakin ingin menghapus user?'" />
                                                    <form method="post" action="{{ route('users.destroy', ['user' => $user->id]) }}" class="hidden" id="form-delete">
                                                        @csrf
                                                        @method('delete')
                                                    </form>
                                                    <script>
                                                        $('#submit-button').click(function() {
                                                            document.getElementById('form-delete').submit();
                                                        });

                                                    </script>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $users->links('pagination.custom-pagi') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
