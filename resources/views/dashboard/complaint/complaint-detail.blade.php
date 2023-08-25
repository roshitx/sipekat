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
                        <form action="" method="">
                            <div class="max-w-lg">
                                <div class="grid grid-cols-1 lg:grid-cols-3 justify-between">
                                    <div class="form-control">
                                        <x-input-label for="status" :value="__('Status')" required />
                                        <x-select-input id="status" name="status" :options="$statusOptions" :selected="$complaint->status" required/>
                                        <x-input-error class="mt-2" :messages="$errors->get('status')" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
