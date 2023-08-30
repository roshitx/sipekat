<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Aduan no $complaint->id") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (Session::has('success'))
            <x-success-alert :message="Session::get('success')" />
            <x-sweetalert :message="Session::get('success')" />
            @endif

            @include('dashboard.complaint.partials.detail')

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-10">
                <div class="p-12 text-gray-800">
                    <div class="max-w-full">
                        <h1 class="text-center font-semibold text-3xl mb-8">Respon Petugas</h1>
                        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'petugas')
                        @include('dashboard.complaint.partials.form-respon')
                        @endif

                        <div class="p-5 bg-white mt-10">
                            @if(!$responses->isEmpty())
                                @include('dashboard.complaint.partials.respon')
                            @else
                            @if (Auth::user()->id == $complaint->user->id)
                            <h1 class="text-center text-black text-lg">Aduan anda belum direspon oleh petugas. Mohon tunggu.</h1>
                            @else
                            <h1 class="text-center text-black text-lg">Aduan ini belum memiliki respon.</h1>
                            @endif
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
