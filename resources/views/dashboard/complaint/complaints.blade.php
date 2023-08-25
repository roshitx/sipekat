<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Aduan') }}
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
                    <x-button-link-primary class="mb-7" href="{{ route('complaints.create') }}"><i data-lucide="megaphone"></i>
                        {{ __('Lapor') }}</x-button-link-primary>

                    <div class="bg-gray-100 rounded-lg px-5 py-3 mb-20">
                        <h1 class="text-3xl font-bold my-5">Aduan anda</h1>
                        <div class="grid grid-col grid-cols-2 lg:grid-cols-4 gap-5">
                            @foreach ($ownedComplaint as $data)
                            <div class="bg-slate-200 group rounded-xl overflow-hidden shadow-md hover:shadow-lg hover:bg-slate-300 transition-all duration-300 ease-out cursor-pointer">
                                <a href="{{ route('complaints.show', $data->id) }}">
                                    <div class="block overflow-hidden relative w-full h-[150px]">
                                        @if ($data->images->count() > 0)
                                        <img class="object-cover w-full h-full transition-transform duration-300 ease-in-out group-hover:scale-105" src="{{ asset('storage/complaint_images/' . $data->images->first()->image_path) }}" draggable="false" alt="Complaint Image" />
                                        @else
                                        <img class="" src="{{ asset('image/placeholder-no-image.png') }}" alt="No Image Uploaded" />
                                        @endif
                                    </div>

                                    <div class="details flex flex-col justify-between">
                                        <h1 class="text-base lg:text-lg font-semibold px-3 mt-1 truncate">{{ $data->title }}</h1>
                                        <p class="px-3 text-xs lg:text-sm text-gray-500">
                                            <x-person-icon /> <span class="align-middle inline-block">{{ $data->user->name }}</span></p>
                                        <p class="px-3 text-xs lg:text-sm text-gray-500 mb-3">
                                            <x-date-icon /> <span class="align-middle inline-block">{{ $data->uploaded_at }}</span></p>
                                        <x-status-alert status="{{ $data->status }}" />
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <h1 class="text-3xl font-bold my-5">Aduan lain</h1>
                    <div class="grid grid-col grid-cols-2 lg:grid-cols-4 gap-5">
                        @foreach ($complaints as $complaint)
                        <div class="bg-slate-200 group rounded-xl overflow-hidden shadow-md hover:shadow-lg hover:bg-slate-300 transition-all duration-300 ease-out cursor-pointer">
                            <a href="{{ route('complaints.show', $complaint->id) }}">
                                <div class="block overflow-hidden relative w-full h-[150px]">
                                    @if ($complaint->images->count() > 0)
                                    <img class="object-cover w-full h-full transition-transform duration-300 ease-in-out group-hover:scale-105" src="{{ asset('storage/complaint_images/' . $complaint->images->first()->image_path) }}" draggable="false" alt="Complaint Image" />
                                    @else
                                    <img class="" src="{{ asset('image/placeholder-no-image.png') }}" alt="No Image Uploaded" />
                                    @endif
                                </div>

                                <div class="details flex flex-col justify-between">
                                    <h1 class="text-base lg:text-lg font-semibold px-3 mt-1 truncate">{{ $complaint->title }}</h1>
                                    <p class="px-3 text-xs lg:text-sm text-gray-500">
                                        <x-person-icon /> <span class="align-middle inline-block">{{ $complaint->user->name }}</span></p>
                                    <p class="px-3 text-xs lg:text-sm text-gray-500 mb-3">
                                        <x-date-icon /> <span class="align-middle inline-block">{{ $complaint->uploaded_at }}</span></p>
                                    <x-status-alert status="{{ $complaint->status }}" />
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
