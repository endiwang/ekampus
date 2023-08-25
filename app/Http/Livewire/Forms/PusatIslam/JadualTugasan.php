<?php

namespace App\Http\Livewire\Forms\PusatIslam;

use App\Concerns\InteractsWithLivewireForm;
use App\Models\PusatIslam\JadualTugasan as Model;
use Livewire\Component;

class JadualTugasan extends Component
{
    use InteractsWithLivewireForm;

    protected string $model = Model::class;

    protected array $rules = [];

    protected string $view = 'livewire.forms.pusat-islam.jadual-tugasan';
}
