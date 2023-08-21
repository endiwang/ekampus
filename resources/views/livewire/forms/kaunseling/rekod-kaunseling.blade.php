<div>
    <h3 class="mb-4">Rekod Kaunseling</h3>

    <x-forms.date label="Tarikh Mula" key="started_at" :value="data_get($state, 'started_at')" wiredName="state.started_at" />
    <x-forms.date label="Tarikh Tamat" key="ended_at" :value="data_get($state, 'ended_at')" wiredName="state.ended_at" />
    <x-forms.select :options="$jenis_kes" label="Jenis Kes" key="jenis_kes" :value="data_get($state, 'jenis_kes')" />
    <x-forms.textarea label="Latar Belakang" key="latar_belakang" :value="data_get($state, 'latar_belakang')" />

    <x-forms.textarea key="situasi_semasa" label="Situasi Semasa" :value="data_get($state, 'situasi_semasa')"/>
    <x-forms.textarea key="sejarah_kesihatan" label="Sejarah Kesihatan" :value="data_get($state, 'sejarah_kesihatan')"/>
    <x-forms.textarea key="harapan_hasil" label="Harapan Hasil" :value="data_get($state, 'harapan_hasil')"/>
    <x-forms.textarea key="cadangan_tindakan" label="Cadangan Tindakan" :value="data_get($state, 'cadangan_tindakan')"/>

    <div class="d-flex justify-content-end">
        <div class="btn btn-sm btn-primary" wire:click="save">
            Simpan
        </div>
    </div>
</div>
