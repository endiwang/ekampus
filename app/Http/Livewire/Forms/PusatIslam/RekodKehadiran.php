<?php

namespace App\Http\Livewire\Forms\PusatIslam;

use App\Concerns\InteractsWithLivewireForm;
use App\Models\PusatIslam\RekodKehadiran as Model;
use Livewire\Component;

class RekodKehadiran extends Component
{
    use InteractsWithLivewireForm;

    protected string $model = Model::class;

    protected array $rules = [];

    protected string $view = 'livewire.forms.pusat-islam.rekod-kehadiran';
}
