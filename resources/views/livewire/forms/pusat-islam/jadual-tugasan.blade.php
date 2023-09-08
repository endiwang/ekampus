<div>
    <div>
        <h3 class="mb-4">Jadual Tugasan</h3>

        <x-forms.date key="state.tarikh" label="Tarikh" :min="now()->format('Y-m-d')" :max="now()
            ->addYear()
            ->format('Y-m-d')"
            wire:model.defer="state.tarikh" />

        <x-forms.select :options="lookup(Lookup::CATEGORY_PUSAT_ISLAM, 'pusat-islam.senarai-solat-wajib')->first()->values" label="Waktu Solat" key="state.waktu_solat" wire:model.defer="state.waktu_solat"
            multiple />

        <x-forms.select :options="['Bilal', 'Imam']" label="Jenis Tugasan" key="state.jenis_tugasan"
            wire:model.defer="state.jenis_tugasan" />

        <x-forms.number key="search" label="Carian" info="Masukkan no kad pengenalan"
            wire:model.debounce.500ms="search" />

        @if (count($users) > 0)
            <x-forms.select :options="$users" wire:loading.remove label="Senarai Petugas" key="state.user"
                wire:model.defer="state.user" />
        @else
            <div class="form-text text-primary flex text-center">Sila lakukan carian untuk pilihan petugas</div>
        @endif

        <div wire:loading class="form-text text-primary flex text-center">Carian dalam process...</div>

        <div class="d-flex justify-content-end">
            <div class="btn btn-sm btn-primary" wire:click="save">
                Simpan
            </div>
        </div>
    </div>
</div>
