<div>
    <h3 class="mb-8">Sesi Pilihan Raya</h3>

    <x-forms.select wire:model.defer="state.jenis" :options="[
        'Ijazah' => 'Ijazah',
        'Diploma' => 'Diploma',
        'Sijil' => 'Sijil',
    ]" label="Jenis" />

    <x-forms.select wire:model.defer="state.semester" :options="[
        'Semester 1' => 'Semester 1',
        'Semester 2' => 'Semester 2',
    ]" label="Semester" />

    <x-forms.date label="Tarikh Penamaan Calon" key="state.tarikh_penamaan_calon"
        wire:model.defer="state.tarikh_penamaan_calon" min="{{ now()->addMonths(1)->format('Y-m-d') }}"
        max="{{ now()->addMonths(6)->format('Y-m-d') }}" />

    <x-forms.date label="Tarikh Mengundi" key="state.tarikh_mengundi" wire:model.defer="state.tarikh_mengundi"
        min="{{ now()->addMonths(1)->addDays(14)->format('Y-m-d') }}"
        max="{{ now()->addMonths(4)->addDays(14)->format('Y-m-d') }}" />

    <h4 class="my-8">Fasal 2</h4>

    <x-forms.number key="state.fasal_2.jumlah_kerusi" label="Jumlah Kerusi Dipertandingkan"
        wire:model.defer="state.fasal_2.jumlah_kerusi" />

    <x-forms.number key="state.fasal_2.kerusi_banin" label="Kerusi BANIN" wire:model.defer="state.fasal_2.kerusi_banin" />

    <h4 class="my-8">Fasal 3</h4>

    <x-forms.number key="state.fasal_3.jumlah_kerusi" label="Jumlah Kerusi Dipertandingkan"
        wire:model.defer="state.fasal_3.jumlah_kerusi" />

    <x-forms.number key="state.fasal_3.kerusi_banat" label="Kerusi BANAT" wire:model.defer="state.fasal_3.kerusi_banat" />

    <div class="d-flex justify-content-end">
        <div class="btn btn-sm btn-primary" wire:click="save">
            Simpan
        </div>
    </div>
</div>
