<div>
    <h3 class="mb-4">Borang Kepuasan Pelanggan</h3>

    <x-forms.select :options="$jenis_kaunseling"
        label="Jenis Kaunseling"
        key="state.jenis_kaunseling"
        wire:model.defer="state.jenis_kaunseling" />

    <x-forms.text key="state.kekerapan_kaunseling"
        label="Kekerapan Kaunseling"
        wire:model.defer="state.kekerapan_kaunseling" />

    <x-forms.textarea key="state.tujuan_kaunseling"
        label="Tujuan Kaunseling"
        description="Tujuan /. Jenis Khidmat Kaunseling Yang Anda Jalani bersama-sama kaunselor
        Jenis pengujian psikologi yang diambil."
        wire:model.defer="state.tujuan_kaunseling" />

    <x-forms.textarea
        key="state.jenis_pengujian"
        label="Jenis Pengujian"
        wire:model.defer="state.jenis_pengujian" />

    <x-forms.textarea
        key="state.hasil_kaunseling"
        label="Hasil Kaunseling"
        description="Nyatakan hasil / kepuasan meleraikan persoalan yang diperolehi dalam sesi kaunseling"
        wire:model.defer="state.hasil_kaunseling" />

    <x-forms.checkbox key="state.matlamat_tercapai" label="Adakah matlamat tercapai?"
        wire:model.defer="state.matlamat_tercapai" :checked="data_get($state, 'matlamat_tercapai')" readonly />

    @if(! $disabled)
        <div class="d-flex justify-content-end">
            <div class="btn btn-sm btn-primary" wire:click="save">
                Simpan
            </div>
        </div>
    @endif
</div>
