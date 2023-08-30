<div>
    <div>
        <h3 class="mb-4">Jana Aktiviti Baru</h3>

        <x-forms.text key="state.nama"
            label="Nama Aktiviti"
            wire:model.defer="state.nama" />

        <x-forms.date key="state.tarikh"
            label="Tarikh" :min="now()->format('Y-m-d')" :max="now()->addYear()->format('Y-m-d')"
            wire:model.defer="state.tarikh" />

        <x-forms.checkbox key="state.hari_kebesaran_islam" label="Adakah Hari Kebesaran Islam?"
            wire:model.defer="state.hari_kebesaran_islam" :checked="data_get($state, 'hari_kebesaran_islam')" />


        <div class="d-flex justify-content-end">
            <div class="btn btn-sm btn-primary" wire:click="save">
                Simpan
            </div>
        </div>

    </div>

</div>
