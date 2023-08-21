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
            'state.jenis_kes' => 'required',
            'state.tarikh' => 'required',
            'state.masalah' => 'required',
            'state.tindakan' => 'required',
            'state.hasil' => 'required',
            'state.catatan' => 'required',
        ];
    }

    public function mount($kaunseling)
    {
        $this->state = $kaunseling->toArray();
        $this->state['id'] = $kaunseling->id;
        $this->jenis_kes = data_get(lookup_kaunseling('kaunseling.jenis-kes')->first(), 'values');
    }

    public function save()
    {
        // need to bind model and display error message
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
