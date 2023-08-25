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
        'nama' => 'required|min:10|max:255',
        'tarikh' => 'required',
    ];

    protected string $view = 'livewire.forms.pusat-islam.activity';
}
