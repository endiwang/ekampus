<?php

namespace App\Http\Livewire\Forms\Kaunseling;

use App\Jobs\Kaunseling\SelesaiKaunselingJob;
use App\Models\Kaunseling;
use Illuminate\Support\Carbon;
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
        $this->state['is_completed'] = $this->state['status'] == Kaunseling::STATUS_SELESAI ? true : false;

        if ($this->state['started_at']) {
            $this->state['started_at'] = Carbon::parse($this->state['started_at'])->format('Y-m-d');
        }

        if ($this->state['ended_at']) {
            $this->state['ended_at'] = Carbon::parse($this->state['ended_at'])->format('Y-m-d');
        }

        $this->jenis_kes = array_combine(
            array_values(data_get(lookup_kaunseling('kaunseling.jenis-kes')->first(), 'values')),
            array_values(data_get(lookup_kaunseling('kaunseling.jenis-kes')->first(), 'values'))
        );
    }

    public function save()
    {
        $this->validate();
        $send_notification = false;
        if (data_get($this->state, 'is_completed') && $this->state['status'] != Kaunseling::STATUS_SELESAI) {
            $this->state['status'] = Kaunseling::STATUS_SELESAI;
            $send_notification = true;
        }

        unset($this->state['is_completed']);

        $kaunseling = Kaunseling::whereId($this->state['id'])->with('user')->firstOrFail();
        $kaunseling->update($this->state);

        if ($send_notification) {
            SelesaiKaunselingJob::dispatch($kaunseling);
        }

        $this->emit('saved');
    }

    public function render()
    {
        return view('livewire.forms.kaunseling.rekod-kaunseling');
    }
}
