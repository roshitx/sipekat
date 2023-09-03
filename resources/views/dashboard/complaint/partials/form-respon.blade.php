<form action="{{ route('respons.store') }}" method="POST">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 mx-auto">
        <input type="hidden" value="{{ $complaint->id }}" name="complaint_id">
        <div class="form-control">
            <x-input-label for="status" :value="__('Status')" required />
            <x-select-input id="status" name="status" :options="$statusOptions" :selected="$complaint->status" required />
            <x-input-error class="mt-2" :messages="$errors->get('status')" />
        </div>

        <div class="form-control">
            <x-input-label for="respon" :value="__('Tanggapan')" required />
            <x-textarea id="respon" name="content" type="text" class="block w-full" :rows="'2'" :placeholder="'Masukan tanggapan..'" required />
            <x-input-error class="mt-2" :messages="$errors->get('content')" />
        </div>

        <div class="form-control mt-4">
            <x-primary-button>{{ __('kirim') }}</x-primary-button>
        </div>
    </div>
</form>
