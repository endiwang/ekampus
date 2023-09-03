<?php

namespace App\Http\Livewire\Forms\KemahiranInsaniah;

use App\Models\KemahiranInsaniah\PilihanRaya\Sesi;
use App\Models\Semester;
use App\Models\SemesterTerkini;
use Livewire\Component;

class PilihanRaya extends Component
{
    public $state = [
        'state.semester' => '',
        'state.fasal_2.jumlah_kerusi' => 0,
        'state.fasal_2.kerusi_banin' => 0,
        'state.fasal_3.jumlah_kerusi' => 0,
        'state.fasal_3.kerusi_banat' => 0,
        'state.jenis' => '',
        'state.tarikh_penamaan_calon' => '',
        'state.tarikh_mengundi' => '',
    ];

    public function rules()
    {
        return [
            'state.semester' => 'required',
            'state.fasal_2.*' => 'required',
            'state.fasal_3.*' => 'required',
            'state.jenis' => 'required',
            'state.tarikh_penamaan_calon' => 'required',
            'state.tarikh_mengundi' => 'required',
        ];
    }

    public function mount($sesi)
    {
        $this->state = $sesi->toArray();
        $this->state['id'] = $sesi->id;
    }

    public function save()
    {
        $this->validate();

        $id = data_get($this->state, 'id');
        unset($this->state['id']);

        if($id) {
            Sesi::query()
                ->where('id', $id)
                ->update($this->state);
        } else {
            Sesi::create($this->state);
        }

        $this->emit('saved');

        $this->redirect(
            route('pengurusan.hep.kemahiran-insaniah.pilihan-raya.index')
        );
    }

    public function render()
    {
        return view('livewire.forms.kemahiran-insaniah.pilihan-raya');
    }
}
