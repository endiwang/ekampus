<?php

namespace App\Http\Livewire\Forms\PusatIslam;

use App\Concerns\InteractsWithLivewireForm;
use App\Models\PusatIslam\Aktiviti as Model;
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
}
