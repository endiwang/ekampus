<?php

namespace App\Http\Livewire\Forms\PusatIslam;

use App\Concerns\InteractsWithLivewireForm;
use App\Models\PusatIslam\KelasOrangAwam as Model;
use Livewire\Component;

class OrangAwam extends Component
{
    use InteractsWithLivewireForm;

    protected string $model = Model::class;

    protected array $rules = [];

    protected string $view = 'livewire.forms.pusat-islam.orang-awam';
}
