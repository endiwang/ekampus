<?php

namespace App\Http\Livewire\Forms\Kaunseling;

use App\Models\Kaunseling;
use Livewire\Component;

class Laporan extends Component
{
    public $state = [];

    public function rules()
    {
        return [
            'state.id' => 'required',
            'state.latar_belakang' => 'required',
            'state.ringkasan' => 'required',
            'state.hasil_konsultasi' => 'required',
        ];
    }

    public function mount($kaunseling)
    {
        $this->state = $kaunseling->toArray();
        $this->state['id'] = $kaunseling->id;
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
        return view('livewire.forms.kaunseling.laporan');
    }
}
