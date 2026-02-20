<div>
    <h1 class="text-2xl font-medium text-slate-900">Pasien</h1>
    <div class="breadcrumbs p-0 text-xs text-slate-500">
        <ul>
            <li><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
            <li><a href="{{ route('patient.index') }}">Pasien</a></li>
            <li>Tambah data baru</li>
        </ul>
    </div>

    <div class="mt-6">
        <form wire:submit="store" method="post">
            @csrf
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div class="card border border-slate-200">
                    <div class="card-body p-6">
                        <h2 class="card-title">Identitas Utama</h2>
                        <div class="grid gap-4">
                            <x-toggle wire:model="is_active" label="Status Aktif" />
                            <x-input wire:model="medical_record_number" label="No. Rekam Medis *" readonly />
                            <x-input wire:model="nik" label="NIK" placeholder="16 digit NIK" maxlength="16" />
                        </div>

                        <x-input wire:model="full_name" label="Nama Lengkap *" />
                        {{-- <x-input wire:model="mother_name" label="Nama Ibu Kandung" /> --}}
                        <x-date wire:model="birth_date" label="Tgl Lahir *" />
                        {{-- <x-input wire:model="birth_place" label="Tempat Lahir" /> --}}
                        <x-select.styled wire:model="gender" label="Jenis Kelamin *" :options="\App\Enums\GenderEnum::choices()" select="label:label|value:value" />

                        <x-textarea wire:model="address" rows="2" label="Alamat *" />

                        <div class="overflow-hidden rounded-lg border border-slate-300" x-data="{ open: false }">
                            <button class="flex w-full items-center justify-between p-4 font-semibold" type="button" @click="open = !open">
                                <span>Alamat Lengkap</span>
                                <svg
                                    class="h-4 w-4 transition-transform duration-200"
                                    :class="{ 'rotate-180': open }"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div class="grid gap-4 p-4 pt-0" x-show="open" x-transition x-cloak>
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
                </div>

                <div class="card border border-slate-200">
                    <div class="card-body p-6">
                        <h2 class="card-title">Kontak</h2>
                        <div class="grid gap-4">
                            <x-input wire:model="mobile_phone" label="No. Handphone / WA" />
                            <x-input type="email" wire:model="email" label="Email" />

                        </div>
                        <h2 class="card-title">Data Lainnya</h2>
                        <div class="grid gap-4">
                            <x-select.styled wire:model="religion" label="Agama" :options="\App\Enums\ReligionEnum::choices()" select="label:label|value:value" />
                            <x-select.styled wire:model="education" label="Pendidikan" :options="\App\Enums\EducationEnum::choices()" select="label:label|value:value" />
                            <x-input wire:model="occupation" label="Pekerjaan" />
                            <x-select.styled wire:model="marital_status" label="Status Perkawinan" :options="\App\Enums\MaritalStatusEnum::choices()"
                                select="label:label|value:value"
                            />
                        </div>
                    </div>
                </div>

                <div class="card border border-blue-200">
                    <div class="card-body p-6">
                        <h2 class="card-title">Booking Pendaftaran</h2>
                        <div class="grid gap-4">
                            <x-date label="Tanggal" />
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-6 flex justify-end gap-2">
                <a class="btn btn-soft btn-secondary" href="{{ route('patient.index') }}" wire:navigate>Batal</a>
                <button class="btn btn-primary" type="submit">Simpan Data Pasien</button>
            </div>
        </form>
    </div>
</div>
