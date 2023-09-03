<?php

namespace App\Concerns;

use Illuminate\Support\Facades\DB;

trait InteractsWithLivewireForm
{
    public $state = [];

    protected $record;

    public function mount($data = null)
    {
        $this->callMethodIfExists('beforerMount', $data);

        if (empty($data)) {
            $class = $this->getModel();
            $data = new $class;
        }
        $this->state = $data->toArray();

        if (data_get($data, 'id')) {
            $this->state['id'] = data_get($data, 'id');
        }

        $this->callMethodIfExists('afterMount');
    }

    public function rules()
    {
        return $this->rules;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getView()
    {
        return $this->view;
    }

    public function callMethodIfExists(string $method, ...$args)
    {
        if (method_exists($this, $method)) {
            $this->{$method}($args);
        }
    }

    public function save()
    {
        $this->callMethodIfExists('beforeValidate');

        $this->validate();

        $this->callMethodIfExists('afterValidate');

        $this->callMethodIfExists('beforeSave');

        $this->record = DB::transaction(function () {
            return isset($this->state['id'])
                ? $this->getModel()::updateOrCreate(['id' => $this->state['id']], $this->state)
                : $this->getModel()::create($this->state);
        });

        $this->callMethodIfExists('afterSave');

        $this->emit('saved');
    }

    public function getRecord()
    {
        return $this->record;
    }

    public function render()
    {
        return view($this->getView());
    }
}
