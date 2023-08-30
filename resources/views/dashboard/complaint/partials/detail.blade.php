<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-12 text-gray-800 overflow-x-auto">
        <div class="max-w-full">
            @if ($complaint->images->count() > 1)
            {{-- Carousel Image --}}
            <div id="default-carousel" class="relative w-full mb-5" data-carousel="slide">
                <!-- Carousel wrapper -->
                <div class="relative h-56 overflow-hidden rounded-lg md:h-96 hover:shadow-xl transition-all duration-300 ease-in-out ">
                    @foreach ($complaintImages as $index => $image)
                    <div class="hidden duration-700 ease-in-out" data-carousel-item="{{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/complaint_images/' . $image->image_path) }}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 cursor-pointer" alt="Complaint Image" onclick="showModal('{{ asset('storage/complaint_images/' . $image->image_path) }}')" />
                    </div>
                    @endforeach
                    {{-- Modal Image --}}
                    <x-modal-image />
                </div>
                <!-- Slider controls -->
                <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>
            @elseif($complaint->images->count() == 1)
            <div class="relative w-full h-56 md:h-96 mb-5 rounded-md overflow-hidden hover:shadow-lg transition-all duration-300 ease-in-out">
                @foreach ($complaintImages as $index => $image)
                <img src="{{ asset('storage/complaint_images/' . $image->image_path) }}" class="w-full cursor-pointer" alt="Complaint Image" onclick="showModal('{{ asset('storage/complaint_images/' . $image->image_path) }}')" />
                @endforeach

                <!-- The Modal -->
                <x-modal-image />
            </div>
            @else
            <div class="relative w-full mb-5 rounded-lg overflow-hidden">
                <img src="{{ asset('image/placeholder-no-image.png') }}" class="w-full" alt="No Image Uploaded">
            </div>
            @endif

            {{-- End Carousel Image --}}

            <h1 class="font-extrabold text-xl lg:text-3xl mb-1">{{ $complaint->title }}</h1>
            <div class="grid grid-cols-2 justify-between relative gap-3">

                <a href="{{ route('users.show', $complaint->user->id) }}" class="text-xs lg:text-sm text-gray-500 hover:text-black transition-colors duration-150">
                    <x-person-icon />
                    <span class="font-medium inline-block align-middle">{{ $complaint->user->name }}</span>
                </a>

                <p class="text-xs lg:text-sm text-gray-500 absolute right-0">
                    <x-date-icon />
                    <span class="inline-block align-middle font-medium">{{ $complaint->uploaded_at }}</span>
                </p>

                <a href="{{ route('users.show', $complaint->user->id) }}" class="text-xs lg:text-sm">
                    <div class="flex items-center text-xs lg:text-sm text-gray-500 group">
                        <!-- Avatar with inset shadow -->
                        <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block group-hover:shadow-lg">
                            @php
                            $user = $complaint->user;
                            $avatar = $user->avatar ? asset('storage/avatar/' . $user->avatar) : Avatar::create($user->name)->toBase64()
                            @endphp
                            <img class="object-cover w-full h-full rounded-full inline-block" src="{{ $avatar }}" alt="Profile Image" loading="lazy" />
                            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                        </div>
                        <div>
                            <span class="inline-block align-middle font-medium"><a href="{{ route('users.show', $complaint->user->id) }}" class="underline hover:text-black transition-colors duration-150 ease-in-out">{{ $user->email }}</a> @if($user->email == Auth::user()->email) <span class="text-secondary text-xs">(You)</span> @endif </span>
                        </div>
                    </div>
                </a>

                <p class="text-xs lg:text-sm text-gray-500 absolute right-0 bottom-2">
                    <x-crown-icon />
                    <span class="inline-block align-middle font-medium">{{ Str::ucfirst($complaint->user->role) }}</span>
                </p>
            </div>

            <div class="max-w-xs hidden md:block mt-2 mb-5">
                <x-badge-status status="{{ $complaint->status }}" />
            </div>

            <article class="mt-3 leading-relaxed text-justify">{{ $complaint->description }}</article>
        </div>
        <div class="max-w-full md:hidden mt-2 mb-10">
            <x-status-alert status="{{ $complaint->status }}" />
        </div>

        <div class="max-w-full flex justify-between gap-5 mt-5 relative">
            <x-button-link-secondary href="{{ route('complaints.index') }}"><i data-lucide="arrow-left-to-line"></i></x-button-link-secondary>
            @if (Auth::user()->role == 'admin' || Auth::user()->email == $complaint->user->email)
            <div class="absolute right-0">
                <x-button-link-primary href="{{ route('complaints.edit', $complaint->slug) }}"><i data-lucide="file-edit"></i> Edit</x-button-link-primary>
                <x-button-danger href="#" data-modal-target="popup-modal" data-modal-toggle="popup-modal"><i data-lucide="trash"></i>{{ __('hapus') }}</x-button-danger>

                {{-- Modal delete respon --}}
                <div id="popup-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-6 text-center">
                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah anda yakin ingin menghapus aduan?</h3>
                                <button data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2" id="submit-button">
                                    Ya, saya yakin.
                                </button>
                                <button data-modal-hide="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Tidak, batal.</button>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="post" action="{{ route('complaints.destroy', ['complaint' => $complaint->id]) }}" class="hidden" id="form-delete">
                    @csrf
                    @method('delete')
                </form>
                <script>
                    $('#submit-button').click(function() {
                        document.getElementById('form-delete').submit();
                    });

                </script>
            </div>
            @endif

        </div>
    </div>
</div>
