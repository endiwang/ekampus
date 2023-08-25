<div>
    <h3 class="mb-4">Laporan</h3>

    <x-forms.textarea key="state.latar_belakang" label="Latar Belakang" wire:model.defer="state.latar_belakang" />
    <x-forms.textarea key="state.ringkasan" label="Ringkasan Kes"
        wire:model.defer="state.ringkasan" />
    <x-forms.textarea key="state.hasil_konsultasi" label="Hasil Konsultasi" wire:model.defer="state.hasil_konsultasi" />

    <div class="d-flex justify-content-end">
        <div class="btn btn-sm btn-primary" wire:click="save">
            Simpan
        </div>
    </div>
</div>
