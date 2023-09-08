<?php

namespace App\Http\Livewire\Forms\PusatIslam;

use App\Concerns\InteractsWithLivewireForm;
use App\Models\PusatIslam\JadualTugasan as Model;
use App\Models\User;
use Livewire\Component;

class JadualTugasan extends Component
{
    use InteractsWithLivewireForm;

    public $state = [
        'tarikh' => '',
        'waktu_solat' => [],
        'jenis_tugasan' => '',
        'user' => '',
    ];

    public $search = '';

    public array $users = [];

    protected string $model = Model::class;

    protected array $rules = [
        'state.tarikh' => 'required',
        'state.waktu_solat' => 'required',
        'state.jenis_tugasan' => 'required',
        'state.user' => 'required',
    ];

    protected string $view = 'livewire.forms.pusat-islam.jadual-tugasan';

    public function updatedSearch()
    {
        if(strlen($this->search) > 2) {
            $students = User::query()
                ->where('is_student', true)
                ->where('is_berhenti', false)
                ->where('is_suspended', false)
                ->where('username', 'like', '%'.$this->search.'%')
                ->whereHas('pelajar')
                ->with([
                    'pelajar' => fn($query) => $query->whereNotNull('nama')->where('jantina', 'L')
                ])
                ->get()
                ->mapWithKeys(function($value, $key) {
                    $value->pelajar = $value->pelajar->first();
                    return [$key => $value];
                })
                ->toArray();

            $staff = User::query()
                ->where('is_staff', true)
                ->where('is_berhenti', false)
                ->where('is_suspended', false)
                ->where('username', 'like', '%'.$this->search.'%')
                ->whereHas('staff')
                ->with([
                    'staff' => fn($query) => $query->whereNotNull('nama')->where('jantina', 'L')
                ])
                ->get()
                ->toArray();

            $this->users = collect()
                ->merge($staff)
                ->merge($students)
                ->filter(function($value, $key) {
                    return (
                        data_get($value, 'is_staff') ? data_get($value, 'staff.jantina') : data_get($value, 'pelajar.0.jantina')
                    ) == 'L';
                })
                ->mapWithKeys(function($value, $key) {
                    return [
                        data_get($value, 'id') => (
                            data_get($value, 'is_staff') ? data_get($value, 'staff.nama') : data_get($value, 'pelajar.0.nama')
                        ) . " - " . data_get($value, 'username')
                    ];
                })
                ->sort()
                ->toArray();
        } else {
            $this->users = [];
        }
        $this->state['user'] = '';
    }

    public function beforeSave()
    {
        $this->state['waktu_solat'] = join(',', data_get($this->state, 'waktu_solat', []));

        // should store id, username, name, email, phone. for now store only user record.
        $field = $this->state['jenis_tugasan'] == 0 ? 'bilal' : 'imam';
        $this->state[$field] =  User::where('id', $this->state['user'])->first()->toArray();

        unset($this->state['jenis_tugasan']);
        unset($this->state['user']);
    }

    public function afterSave()
    {
        $this->state = [
            'tarikh' => '',
            'waktu_solat' => [],
            'jenis_tugasan' => '',
            'user' => '',
        ];
    }

    public function afterEmitSaved()
    {
        return $this->redirect(
            route('pengurusan.hep.pusat-islam.jadual-tugasan.index')
        );
    }
}
