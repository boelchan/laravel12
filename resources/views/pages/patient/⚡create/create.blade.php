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
                    <div class="card-body space-y-2">
                        <h2 class="card-title">Identitas Utama</h2>
                        <x-toggle wire:model="is_active" label="Status Aktif" />
                        <x-input wire:model="medical_record_number" label="No. Rekam Medis *" readonly />
                        <x-input wire:model="nik" label="NIK" placeholder="16 digit NIK" maxlength="16" />

                        <x-input wire:model="full_name" label="Nama Lengkap *" />
                        <x-select.styled wire:model="gender" label="Jenis Kelamin *" :options="\App\Enums\GenderEnum::choices()" select="label:label|value:value" />
                        <x-date wire:model="birth_date" label="Tanggal Lahir" />

                        <x-input wire:model="mobile_phone" label="No. Handphone / WA" />
                        <x-input type="email" wire:model="email" label="Email" />
                    </div>
                </div>

                <div class="card border border-slate-200">
                    <div class="card-body space-y-2">
                        <h2 class="card-title">Alamat</h2>
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
                                    label="Desa *"
                                    placeholder="Pilih Desa"
                                    :options="$villages"
                                    searchable
                                />
                            @else
                                <x-select.styled label="Desa" placeholder="Pilih Kecamatan terlebih dahulu" disabled />
                            @endif
                        </div>
                        <x-textarea wire:model="address" rows="2" label="Alamat" />

                    </div>
                </div>

                <div class="card border border-blue-200">
                    <div class="card-body space-y-2">
                        <h2 class="card-title">Booking Pendaftaran</h2>
                        <x-date wire:model="booking_date" label="Tanggal" :min-date="now()" />
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
