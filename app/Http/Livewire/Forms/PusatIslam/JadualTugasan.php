<?php

namespace App\Http\Livewire\Forms\PusatIslam;

use App\Concerns\InteractsWithLivewireForm;
use App\Models\Lookup;
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

    protected function afterMount()
    {
        if(data_get($this->state, 'user.username')) {
            $this->search = data_get($this->state, 'user.username');
            $this->updatedSearch();
            $this->state['user'] = array_keys($this->users)[0];

            $this->state['jenis_tugasan'] = $this->state['is_bilal'] ? 0 : 1;

            $waktu_solat = lookup(Lookup::CATEGORY_PUSAT_ISLAM, 'pusat-islam.senarai-solat-wajib')->first()->values;

            foreach($waktu_solat as $key => $value) {
                $field = 'is_' . strtolower($value);

                if($this->state[$field] == true) {
                    $this->state['waktu_solat'][] = $key;
                }
            }
        }
    }

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
        $waktu_solat = lookup(Lookup::CATEGORY_PUSAT_ISLAM, 'pusat-islam.senarai-solat-wajib')->first()->values;
        foreach ($waktu_solat as $key => $value) {
            $field = 'is_'. strtolower($value);
            $this->state[$field] = array_key_exists($key, data_get($this->state, 'waktu_solat')) ? true : false;
        }

        $this->state['is_bilal'] = $this->state['jenis_tugasan'] == 0;
        $this->state['is_imam'] = $this->state['jenis_tugasan'] == 1;

        $field = $this->state['jenis_tugasan'] == 0 ? 'bilal' : 'imam';
        $user = User::query()
            ->where('id', $this->state['user'])
            ->first();

        $user->load($user->is_staff ? 'staff' : 'pelajar');

        $user_info = [
            'id' => $user->id,
            'username' => $user->username,
            'name' => $user->is_staff ? $user->staff->nama : $user->pelajar->first()->nama,
            'ic' => $user->is_staff ? $user->staff->no_ic : $user->pelajar->first()->no_ic,
            'email' => $user->is_staff ? $user->staff->email : $user->pelajar->first()->email,
            'phone_number' => $user->is_staff ? $user->staff->no_tel : $user->pelajar->first()->no_tel,
        ];

        $this->state['user'] =  $user_info;

        unset($this->state['jenis_tugasan']);
        unset($this->state['waktu_solat']);
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
            route('pengurusan.hep.pusat-islam.jadual-tugasans.index')
        );
    }
}
