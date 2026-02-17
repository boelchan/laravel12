<div>
    <h1 class="text-2xl font-medium text-slate-900">Pasien</h1>
    <div class="breadcrumbs p-0 text-xs text-slate-500">
        <ul>
            <li><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
            <li><a href="{{ route('patient') }}">Pasien</a></li>
            <li>Tambah data baru</li>
        </ul>
    </div>

    <div class="mt-6">
        <form wire:submit="store" method="post">
            @csrf
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                {{-- IDENTITAS UTAMA --}}
                <div class="card border border-slate-200">
                    <div class="card-body p-6">
                        <h2 class="card-title">Identitas Utama</h2>
                        <div class="grid gap-4">
                            <x-input wire:model="medical_record_number" label="No. Rekam Medis *" readonly />
                            <x-input wire:model="nik" label="NIK" placeholder="16 digit NIK" maxlength="16" />
                            <x-toggle wire:model="is_active" label="Status Aktif" />
                        </div>
                    </div>
                </div>

                {{-- DATA PERSONAL --}}
                <div class="card border border-slate-200">
                    <div class="card-body p-6">
                        <h2 class="card-title">Data Personal</h2>
                        <div class="grid gap-4">
                            <x-input wire:model="full_name" label="Nama Lengkap *" />
                            <x-input wire:model="mother_name" label="Nama Ibu Kandung" />
                            <div class="grid grid-cols-2 gap-4">
                                <x-date wire:model="birth_date" label="Tgl Lahir *" />
                                <x-input wire:model="birth_place" label="Tempat Lahir" />
                            </div>
                            <x-select.styled wire:model="gender" label="Jenis Kelamin *" :options="\App\Enums\GenderEnum::choices()"
                                select="label:label|value:value" />
                        </div>
                    </div>
                </div>

                {{-- KONTAK --}}
                <div class="card border border-slate-200">
                    <div class="card-body p-6">
                        <h2 class="card-title">Kontak</h2>
                        <div class="grid gap-4">
                            <x-input wire:model="mobile_phone" label="No. Handphone / WA" />
                            <x-input wire:model="phone" label="No. Telepon" />
                            <x-input type="email" wire:model="email" label="Email" />
                        </div>
                    </div>
                </div>

                {{-- ALAMAT --}}
                <div class="card border border-slate-200  lg:col-span-2">
                    <div class="card-body p-6">
                        <h2 class="card-title">Alamat</h2>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <x-textarea wire:model="address" label="Alamat *" />
                            </div>

                            {{-- PROVINSI --}}
                            <x-select.styled
                                id="province-select"
                                wire:model.live="province_code"
                                label="Provinsi"
                                placeholder="Pilih Provinsi"
                                :options="$provinces"
                                searchable
                            />

                            {{-- KOTA / KABUPATEN --}}
                            <div wire:key="wrapper-regency-{{ $province_code }}-{{ count($regencies) }}">
                                @if ($province_code && count($regencies) > 0)
                                    <x-select.styled
                                        id="regency-select-{{ $province_code }}"
                                        wire:model.live="regency_code"
                                        label="Kota / Kabupaten"
                                        placeholder="Pilih Kota/Kabupaten"
                                        :options="$regencies"
                                        searchable
                                    />
                                @else
                                    <x-select.styled label="Kota / Kabupaten" placeholder="Pilih Provinsi terlebih dahulu" disabled />
                                @endif
                            </div>

                            {{-- KECAMATAN --}}
                            <div wire:key="wrapper-district-{{ $regency_code }}-{{ count($districts) }}">
                                @if ($regency_code && count($districts) > 0)
                                    <x-select.styled
                                        id="district-select-{{ $regency_code }}"
                                        wire:model.live="district_code"
                                        label="Kecamatan"
                                        placeholder="Pilih Kecamatan"
                                        :options="$districts"
                                        searchable
                                    />
                                @else
                                    <x-select.styled label="Kecamatan" placeholder="Pilih Kota/Kabupaten terlebih dahulu" disabled />
                                @endif
                            </div>

                            {{-- KELURAHAN / DESA --}}
                            <div wire:key="wrapper-village-{{ $district_code }}-{{ count($villages) }}">
                                @if ($district_code && count($villages) > 0)
                                    <x-select.styled
                                        id="village-select-{{ $district_code }}"
                                        wire:model.live="village_code"
                                        label="Kelurahan / Desa"
                                        placeholder="Pilih Kelurahan/Desa"
                                        :options="$villages"
                                        searchable
                                    />
                                @else
                                    <x-select.styled label="Kelurahan / Desa" placeholder="Pilih Kecamatan terlebih dahulu" disabled />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DATA KEPENDUDUKAN & LAINNYA --}}
                <div class="card border border-slate-200">
                    <div class="card-body p-6">
                        <h2 class="card-title">Data Kependudukan & Lainnya</h2>
                        <div class="grid gap-4">
                            <x-select.styled wire:model="nationality" label="Kewarganegaraan" :options="\App\Enums\NationalityEnum::choices()"
                                select="label:label|value:value"
                            />
                            <x-select.styled wire:model="religion" label="Agama" :options="\App\Enums\ReligionEnum::choices()" select="label:label|value:value" />
                            <x-select.styled wire:model="education" label="Pendidikan" :options="\App\Enums\EducationEnum::choices()" select="label:label|value:value" />
                            <x-input wire:model="occupation" label="Pekerjaan" />
                            <x-select.styled wire:model="marital_status" label="Status Perkawinan" :options="\App\Enums\MaritalStatusEnum::choices()"
                                select="label:label|value:value"
                            />
                        </div>
                    </div>
                </div>

                {{-- ASURANSI & KONTAK DARURAT --}}
                <div class="card border border-slate-200">
                    <div class="card-body p-6">
                        <h2 class="card-title">Kontak Darurat</h2>
                        <div class="grid grid-cols-1 gap-4">
                            <x-input wire:model="emergency_contact_name" label="Nama Kontak Darurat" />
                            <x-input wire:model="emergency_contact_relation" label="Hubungan Keluarga" />
                            <x-input wire:model="emergency_contact_phone" label="No. HP Kontak Darurat" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-2">
                <a class="btn btn-soft btn-secondary" href="{{ route('patient') }}" wire:navigate>Batal</a>
                <button type="submit" class="btn btn-soft btn-primary">Simpan Data Pasien</button>
            </div>
        </form>
    </div>
</div>
