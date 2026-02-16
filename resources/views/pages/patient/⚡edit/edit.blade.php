<div>
    <h1 class="text-2xl font-medium text-slate-900">Pasien</h1>
    <div class="breadcrumbs p-0 text-xs text-slate-500">
        <ul>
            <li><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
            <li><a href="{{ route('patient') }}">Pasien</a></li>
            <li>Edit data</li>
        </ul>
    </div>

    <div class="mt-6">
        <form wire:submit="update" method="post">
            @csrf
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                {{-- IDENTITAS UTAMA --}}
                <x-card title="Identitas Utama">
                    <div class="grid gap-4">
                        <x-input wire:model="medical_record_number" label="No. Rekam Medis *" readonly />
                        <x-input wire:model="nik" label="NIK" placeholder="16 digit NIK" maxlength="16" />
                        <x-input wire:model="ihs_number" label="No. IHS" placeholder="Satu Sehat ID" />
                        <x-input wire:model="passport_kitas" label="Paspor / KITAS" placeholder="Khusus WNA" />
                    </div>
                </x-card>

                {{-- DATA PERSONAL --}}
                <x-card title="Data Personal">
                    <div class="grid gap-4">
                        <x-input wire:model="full_name" label="Nama Lengkap *" />
                        <x-input wire:model="mother_name" label="Nama Ibu Kandung" />
                        <div class="grid grid-cols-2 gap-4">
                            <x-input type="date" wire:model="birth_date" label="Tgl Lahir *" />
                            <x-input wire:model="birth_place" label="Tempat Lahir" />
                        </div>
                        <x-select.styled wire:model="gender" label="Jenis Kelamin *" :options="\App\Enums\GenderEnum::choices()" select="label:label|value:value" />
                    </div>
                </x-card>

                {{-- KONTAK --}}
                <x-card title="Kontak">
                    <div class="grid gap-4">
                        <x-input wire:model="mobile_phone" label="No. Handphone" />
                        <x-input wire:model="phone" label="No. Telepon" />
                        <x-input type="email" wire:model="email" label="Email" />
                        <x-toggle wire:model="is_active" label="Status Aktif" />
                    </div>
                </x-card>

                {{-- ALAMAT --}}
                <x-card class="lg:col-span-2" title="Alamat">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <x-textarea wire:model="address" label="Alamat Lengkap" />
                        </div>
                        <div>
                            <label class="label"><span class="label-text">Provinsi</span></label>
                            <select wire:model.live="province_code" class="select select-bordered w-full">
                                <option value="">Pilih Provinsi</option>
                                @foreach ($provinces as $prov)
                                    <option value="{{ $prov['value'] }}">{{ $prov['label'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="label"><span class="label-text">Kota / Kabupaten</span></label>
                            <select wire:model.live="regency_code" class="select select-bordered w-full" @disabled(!$province_code)>
                                <option value="">Pilih Kota/Kabupaten</option>
                                @foreach ($regencies as $reg)
                                    <option value="{{ $reg['value'] }}">{{ $reg['label'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="label"><span class="label-text">Kecamatan</span></label>
                            <select wire:model.live="district_code" class="select select-bordered w-full" @disabled(!$regency_code)>
                                <option value="">Pilih Kecamatan</option>
                                @foreach ($districts as $dist)
                                    <option value="{{ $dist['value'] }}">{{ $dist['label'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="label"><span class="label-text">Kelurahan / Desa</span></label>
                            <select wire:model.live="village_code" class="select select-bordered w-full" @disabled(!$district_code)>
                                <option value="">Pilih Kelurahan/Desa</option>
                                @foreach ($villages as $vil)
                                    <option value="{{ $vil['value'] }}">{{ $vil['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-input wire:model="postal_code" label="Kode Pos" />
                    </div>
                </x-card>

                {{-- DATA KEPENDUDUKAN & LAINNYA --}}
                <x-card title="Data Kependudukan & Lainnya">
                    <div class="grid gap-4">
                        <x-select.styled wire:model="nationality" label="Kewarganegaraan" :options="\App\Enums\NationalityEnum::choices()"
                            select="label:label|value:value" />
                        <x-select.styled wire:model="religion" label="Agama" :options="\App\Enums\ReligionEnum::choices()" select="label:label|value:value" />
                        <x-select.styled wire:model="education" label="Pendidikan" :options="\App\Enums\EducationEnum::choices()" select="label:label|value:value" />
                        <x-input wire:model="occupation" label="Pekerjaan" />
                        <x-select.styled wire:model="marital_status" label="Status Perkawinan" :options="\App\Enums\MaritalStatusEnum::choices()"
                            select="label:label|value:value"
                        />
                    </div>
                </x-card>

                {{-- ASURANSI & KONTAK DARURAT --}}
                <x-card class="lg:col-span-2" title="Asuransi & Kontak Darurat">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="grid grid-cols-2 gap-4 md:col-span-2">
                            <x-input wire:model="insurance_number" label="No. BPJS / Asuransi" />
                            <x-input wire:model="insurance_name" label="Nama Asuransi" />
                        </div>
                        <x-input wire:model="emergency_contact_name" label="Nama Kontak Darurat" />
                        <x-input wire:model="emergency_contact_relation" label="Hubungan Keluarga" />
                        <x-input wire:model="emergency_contact_phone" label="No. HP Kontak Darurat" />
                    </div>
                </x-card>
            </div>

            <div class="mt-6 flex justify-end gap-2">
                <a class="btn btn-soft btn-secondary" href="{{ route('patient') }}" wire:navigate>Batal</a>
                <x-button type="submit" primary>Update Data Pasien</x-button>
            </div>
        </form>
    </div>
</div>
