<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-12 text-gray-800 overflow-x-auto">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Tambah User') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Mohon isi kolom dibawah dengan benar.') }}
                        </p>
                    </header>
                    <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data" class="mt-6 space-y-6">
                        @csrf

                        <div class="max-w-xl">
                            <div class="form-control">
                                <x-input-label for="name" :value="__('Nama')" required />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                        </div>

                        <div class="max-w-xl">
                            <div class="form-control">
                                <x-input-label for="email" :value="__('Email')" required />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>
                        </div>

                        <div class="max-w-xl">
                            <div class="form-control">
                                <x-input-label for="gender" :value="__('Jenis Kelamin')" />
                                <x-select-input id="gender" name="gender" :options="$genderOptions" />
                                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                            </div>
                        </div>

                        <div class="max-w-xl">
                            <div class="form-control">
                                <x-input-label for="role" :value="__('Role')" required />
                                <x-select-input id="role" name="role" :options="$roleOptions" required />
                                <x-input-error class="mt-2" :messages="$errors->get('role')" />
                            </div>
                        </div>

                        <div class="max-w-xl">
                            <div class="form-control">
                                <x-input-label for="password" :value="__('Password')" required />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" :value="old('name')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>
                        </div>

                        <div class="max-w-xl">
                            <div class="form-control">
                                <x-input-label for="avatar" :value="__('Foto Profil')" />

                                <x-image-input />
                                @error('avatar')
                                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                                @else
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">PNG, JPG, or JPEG (MAX.
                                    2048kb).</p>
                                @enderror
                            </div>
                        </div>
                        <x-primary-button>Simpan</x-primary-button>
                        <x-button-link-secondary href="{{ route('users') }}">Batal</x-button-link-secondary>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
