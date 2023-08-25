<?php

namespace App\Concerns;

trait InteractsWithResourceController
{
    public function getResourceUrl(string $type = 'index')
    {
        return $type === 'index'
            ? route($this->getUrlRouteBaseName().'.index')
            : route($this->getUrlRouteBaseName().'.'.$type, $this);
    }

    public function getUrlRouteBaseName()
    {
        if (property_exists($this, 'routeBaseName')) {
            return $this->routeBaseName;
        }

        return str(get_called_class())->classBasename()->kebab()->plural()->toString();
    }

    protected function getModuleView(): string
    {
        return $this->moduleView;
    }

    protected function getCompactname(): string
    {
        return $this->compactName;
    }

    protected function getModel()
    {
        return $this->model::query();
    }

    public function show($id)
    {
        $data = $this->getModel()::whereId($id)->firstOrFail();

        $this->authorize('view', $data);

        return view($this->getModuleView().'.show', [
            $this->getCompactname() => $data,
        ]);
    }

    public function edit($id)
    {
        $data = $this->getModel()::whereId($id)->firstOrFail();

        $this->authorize('update', $data);

        return view($this->getModuleView().'.form', [
            $this->getCompactname() => $data,
        ]);
    }
}
