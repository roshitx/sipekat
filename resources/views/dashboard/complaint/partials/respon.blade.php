@foreach ($responses as $response)
<div tabindex="0" class="collapse collapse-arrow mb-2 border-b border-gray-300">
    <div class="collapse-title text-xl font-medium">
        <div class="flex items-center relative">
            <div class="avatar mr-3">
                @php
                $user = $response->user;
                $avatar = $user->avatar ? asset('storage/avatar/' . $user->avatar) : Avatar::create($user->name)->toBase64();
                @endphp
                <div class="w-11 lg:w-14 rounded-full">
                    <img src="{{ $avatar }}" />
                </div>
            </div>
            <div class="flex flex-col">
                <a href="{{ route('users.show', $response->user->id) }}" class="text-black font-semibold text-lg hover:text-slate-600 hover:underline transition-all duration-200 ease-in-out">{{ $response->user->name }}</a>
                <p class="text-gray-500 font-medium text-sm">{{ Str::ucfirst($response->user->role) }}</p>
                <p class="text-sm text-gray-500">{{ $response->updated_at->format('d M Y, H:i') . ' WIB.' }}</p>
            </div>
            @if(Auth::user()->id === $response->user_id)
            <div class="absolute right-0">

                {{-- Button delete --}}
                <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete" data-modal-target="popup-modal-respon-{{ $response->id }}" data-modal-toggle="popup-modal-respon-{{ $response->id }}">
                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </button>

                {{-- Modal delete respon --}}
                <div id="popup-modal-respon-{{ $response->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal-respon-{{ $response->id }}">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-6 text-center">
                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah anda yakin ingin menghapus respon?</h3>
                                <button data-modal-hide="popup-modal-respon-{{ $response->id }}" data-respon-id="{{ $response->id }}" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2" id="submit-button-respon">
                                    Ya, saya yakin.
                                </button>
                                <button data-modal-hide="popup-modal-respon-{{ $response->id }}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Tidak, batal.</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form delete --}}
                <form method="post" action="{{ route('respons.destroy', ['respon' => $response->id]) }}" class="hidden" id="form-delete-respon-{{ $response->id }}">
                    @csrf
                    @method('delete')
                </form>
                <script>
                    $(document).ready(function() {
                        $('[data-respon-id]').click(function() {
                            var responId = $(this).data('respon-id');
                            $('#form-delete-respon-' + responId).submit();
                        });
                    });

                </script>
            </div>
            @endif
        </div>
    </div>
    <div class="collapse-content">

        <article class="text-black text-base">
            {{ $response->content }}
        </article>
    </div>
</div>
@endforeach
