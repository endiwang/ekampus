<?php

namespace App\Concerns;

trait InteractsWithLivewireForm
{
    public $state = [];

    protected $record;

    public function mount($data = null)
    {
        if (empty($data)) {
            $class = $this->getModel();
            $data = new $class;
        }
        $this->state = $data->toArray();
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

        $this->record = $this->getModel()::query()
            ->when(
                isset($this->state['id']),
                fn ($query) => $query->whereId($this->state['id'])
            )->updateOrCreate($this->state);

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
