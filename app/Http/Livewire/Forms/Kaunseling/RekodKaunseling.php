<?php

namespace App\Http\Livewire\Forms\Kaunseling;

use App\Models\Kaunseling;
use Livewire\Component;

class RekodKaunseling extends Component
{
    public $state = [];

    public $jenis_kes = [];

    public function rules()
    {
        return [
            'state.id' => 'required',
            'state.started_at' => 'required',
            'state.ended_at' => 'required',
            'state.jenis_kes' => 'required',
            'state.latar_belakang' => 'required',
            'state.situasi_semasa' => 'required',
            'state.sejarah_kesihatan' => 'required',
            'state.harapan_hasil' => 'required',
            'state.cadangan_tindakan' => 'required',
        ];
    }

    public function mount($kaunseling)
    {
        $this->state = $kaunseling->toArray();
        $this->state['id'] = $kaunseling->id;
        $this->jenis_kes = array_combine(
            array_values(data_get(lookup_kaunseling('kaunseling.jenis-kes')->first(), 'values')),
            array_values(data_get(lookup_kaunseling('kaunseling.jenis-kes')->first(), 'values'))
        );
    }

    public function save()
    {
        $this->validate();

        $kaunseling = Kaunseling::whereId($this->state['id'])->firstOrFail();
        $kaunseling->update($this->state);

        $this->emit('saved');
    }

    public function render()
    {
        return view('livewire.forms.kaunseling.rekod-kaunseling');
    }
}
