<?php

namespace App\Http\Livewire\Forms\Kaunseling;

use App\Models\Kaunseling;
use Livewire\Component;

class BorangKepuasanPelanggan extends Component
{
    public $state = [];

    public $jenis_kaunseling;

    public $disabled = false;

    public function rules()
    {
        return [
            'state.id' => 'required',
            'state.jenis_kaunseling' => 'required',
            'state.kekerapan_kaunseling' => 'required',
            'state.tujuan_kaunseling' => 'required',
            'state.jenis_pengujian' => 'required',
            'state.hasil_kaunseling' => 'required',
        ];
    }

    public function mount($kaunseling)
    {
        $this->state = $kaunseling->toArray();
        $this->state['id'] = $kaunseling->id;

        $this->jenis_kaunseling = array_combine(
            array_values(data_get(lookup_kaunseling('kaunseling.jenis-kaunseling')->first(), 'values')),
            array_values(data_get(lookup_kaunseling('kaunseling.jenis-kaunseling')->first(), 'values'))
        );

        $this->disabled = $this->isDisabled();
    }

    private function isDisabled()
    {
        return
            ! empty(data_get($this->state, 'jenis_kaunseling')) &&
            ! empty(data_get($this->state, 'kekerapan_kaunseling')) &&
            ! empty(data_get($this->state, 'tujuan_kaunseling')) &&
            ! empty(data_get($this->state, 'jenis_pengujian')) &&
            ! empty(data_get($this->state, 'hasil_kaunseling'));
    }

    public function save()
    {
        $this->validate();

        $kaunseling = Kaunseling::whereId($this->state['id'])->firstOrFail();
        $kaunseling->update($this->state);

        $subject = 'Borang Kepuasan Pelanggan ' . $kaunseling->no_permohonan;
        $message = 'Kami ingin mengucapkan ribuan terima kasih kerana telah meluangkan masa anda untuk mengisi borang kepuasan pelanggan selepas sesi kaunseling. Penglibatan anda dalam memberikan maklum balas sangat berharga bagi kami dalam usaha kami untuk terus meningkatkan perkhidmatan kaunseling kami.';

        notify($kaunseling->user, $subject, $message);

        $this->emit('saved');
    }


    public function render()
    {
        return view('livewire.forms.kaunseling.borang-kepuasan-pelanggan');
    }
}
