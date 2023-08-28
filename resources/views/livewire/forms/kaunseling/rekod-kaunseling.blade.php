<div>
    <h3 class="mb-4">Rekod Kaunseling</h3>

    <x-forms.date label="Tarikh Mula" key="state.started_at" wire:model.defer="state.started_at"
        min="{{ now()->format('Y-m-d') }}" max="{{ now()->addMonths(3)->format('Y-m-d') }}" />
    <x-forms.date label="Tarikh Tamat" key="state.ended_at" wire:model.defer="state.ended_at"
        min="{{ now()->format('Y-m-d') }}" max="{{ now()->addMonths(3)->format('Y-m-d') }}" />
    <x-forms.select :options="$jenis_kes" label="Jenis Kes" key="state.jenis_kes" wire:model.defer="state.jenis_kes" />
    <x-forms.textarea label="Latar Belakang" key="state.latar_belakang" wire:model.defer="state.latar_belakang" />

    <x-forms.textarea key="state.situasi_semasa" label="Situasi Semasa" wire:model.defer="state.situasi_semasa" />
    <x-forms.textarea key="state.sejarah_kesihatan" label="Sejarah Kesihatan"
        wire:model.defer="state.sejarah_kesihatan" />
    <x-forms.textarea key="state.harapan_hasil" label="Harapan Hasil" wire:model.defer="state.harapan_hasil" />
    <x-forms.textarea key="state.cadangan_tindakan" label="Cadangan Tindakan"
        wire:model.defer="state.cadangan_tindakan" />

    <x-forms.checkbox key="state.is_completed" label="Sesi Kaunseling Selesai?"
        wire:model.defer="state.is_completed" :checked="data_get($state, 'is_completed')" />

    @if(data_get($state, 'status') == \App\Models\Kaunseling::STATUS_DITERIMA)
        <div class="d-flex justify-content-end">
            <div class="btn btn-sm btn-primary" wire:click="save">
                Simpan
            </div>
        </div>
    @endif
</div>
