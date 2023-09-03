<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ubah Aduan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-12 text-gray-800 overflow-x-auto">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Edit Aduan') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Mohon isi semua kolom dengan benar dan valid, segala bentuk laporan yang teridentifikasi hoax dapat dikenai pasal pidana.') }}
                        </p>
                    </header>
                    <form action="{{ route('complaints.update', $complaint->id) }}" method="post" enctype="multipart/form-data" class="mt-6 space-y-6">
                        @csrf
                        @method('PATCH')

                        <div class="max-w-xl">
                            <div class="form-control">
                                <x-input-label for="title" :value="__('Judul Aduan')" required />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :placeholder="'Masukan judul aduan..'" :value="$complaint->title" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('title')" />
                            </div>
                        </div>

                        <div class="max-w-xl">
                            <div class="form-control">
                                <x-input-label for="image_path" :value="__('Gambar/Foto Pendukung')" />

                                <x-image-path />
                                @error('image_path')
                                <x-input-error class="mt-2" :messages="$errors->get('image_path')" />
                                @else
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">PNG, JPG, or JPEG (MAX.
                                    5Mb).</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Geolocation Start --}}
                        <div class="max-w-xl">
                            <div class="form-control">
                                <x-input-label for="province" :value="__('Provinsi')" />
                                <select name="province" id="selectProv" class="border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm">
                                    <option value="{{ $complaint->province }}">{{ $complaint->province }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="max-w-xl">
                            <div class="form-control">
                                <x-input-label for="regency" :value="__('Kabupaten/Kota')" />
                                <select name="regency" id="selectRegenc" class="border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm">
                                    <option value="{{ $complaint->regency }}">{{ $complaint->regency }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="max-w-xl">
                            <div class="form-control">
                                <x-input-label for="district" :value="__('Kecamatan')" />
                                <select name="district" id="selectDistrict" class="border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm">
                                    <option value="{{ $complaint->district }}">{{ $complaint->district }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="max-w-xl">
                            <div class="form-control">
                                <x-input-label for="village" :value="__('Desa/Kelurahan')" />
                                <select name="village" id="selectVillage" class="border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm">
                                    <option value="{{ $complaint->village }}">{{ $complaint->village }}</option>
                                </select>
                            </div>
                        </div>
                        {{-- Geolocation End --}}

                        <div class="max-w-xl">
                            <div class="form-control">
                                <x-input-label for="description" :value="__('Deskripsi Aduan')" required />
                                <x-textarea id="description" rows="5" name="description" type="text" class="mt-1 block w-full" :placeholder="'Masukan detail aduan, sertakan lokasi dan bukti yang kuat'" value="{{ $complaint->description }}" required></x-textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>
                        </div>

                        <div class="max-w-xl">
                            <div class="form-control">
                                <x-input-label for="captcha" :value="__('Captcha')" required />
                                <div class="flex flex-row items-center mt-2 captcha">
                                    <span class="mr-2">{!! captcha_img('flat') !!}</span>
                                    <button type="button" class="btn btn-secondary btn-sm" id="reload">
                                        <i data-lucide="refresh-ccw"></i>
                                    </button>
                                    <script>
                                        $('#reload').click(function() {
                                            $.ajax({
                                                type: 'GET'
                                                , url: '{{ route('reload.captcha') }}'
                                                , success: function(data) {
                                                    $('.captcha span').html(data.captcha)
                                                }
                                            , });
                                        });

                                    </script>
                                </div>
                                <x-text-input :placeholder="'Masukan captcha..'" id="captcha" name="captcha" class="mt-2" />
                                <x-input-error class="mt-2" :messages="$errors->get('captcha')" />
                            </div>
                        </div>

                        <x-primary-button>Simpan</x-primary-button>
                        <x-button-link-secondary href="{{ route('complaints.show', $complaint->slug) }}">Batal</x-button-link-secondary>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $("#selectProv").select2({
                placeholder: 'Pilih Provinsi', 
                ajax: {
                    url: "{{ route('provinsi.index') }}", 
                    processResults: function({
                        data
                    }) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id, 
                                    text: item.name
                                }
                            })
                        }
                    }
                }
            });

            $("#selectProv").change(function() {
                let id = $("#selectProv").val();

                $("#selectRegenc").select2({
                    placeholder: 'Pilih Kabupaten/Kota', 
                    ajax: {
                        url: "{{ url('selectRegenc') }}/"+ id, 
                        processResults: function({
                            data
                        }) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        id: item.id, 
                                        text: item.name
                                    }
                                })
                            }
                        }
                    }
                });
            });

            $("#selectRegenc").change(function() {
                let id = $("#selectRegenc").val();

                $("#selectDistrict").select2({
                    placeholder: 'Pilih Kecamatan', 
                    ajax: {
                        url: "{{ url('selectDistrict') }}/"+ id, 
                        processResults: function({
                            data
                        }) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        id: item.id, 
                                        text: item.name
                                    }
                                })
                            }
                        }
                    }
                });
            });

            $("#selectDistrict").change(function() {
                let id = $("#selectDistrict").val();

                $("#selectVillage").select2({
                    placeholder: 'Pilih Desa/Kelurahan', 
                    ajax: {
                        url: "{{ url('selectVillage') }}/"+ id, 
                        processResults: function({
                            data
                        }) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        id: item.id, 
                                        text: item.name
                                    }
                                })
                            }
                        }
                    }
                });
            });
        });

    </script>
</x-app-layout>
