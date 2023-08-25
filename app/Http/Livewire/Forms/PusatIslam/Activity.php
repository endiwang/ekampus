<?php

namespace App\Http\Livewire\Forms\PusatIslam;

use App\Concerns\InteractsWithLivewireForm;
use App\Models\PusatIslam\Aktiviti as Model;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Activity extends Component
{
    use InteractsWithLivewireForm;

    protected string $model = Model::class;

    protected array $rules = [
        'state.nama' => 'required|min:10|max:255',
        'state.tarikh' => 'required',
    ];

    protected string $view = 'livewire.forms.pusat-islam.activity';

    public function afterMount()
    {
        $this->state['tarikh'] = ! empty($this->state['tarikh'])
            ? Carbon::parse($this->state['tarikh'])->format('Y-m-d')
            : null;
    }

    public function afterSave()
    {
        if (method_exists($this->getRecord(), 'getResourceUrl')) {
            return redirect()->to($this->getRecord()->getResourceUrl());
        }
    }
}
