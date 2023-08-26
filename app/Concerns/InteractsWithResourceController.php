<?php

namespace App\Concerns;

trait InteractsWithResourceController
{
    protected function getModuleView(): string
    {
        return $this->moduleView;
    }

    protected function getCompactname(): string
    {
        return $this->compactName;
    }

    protected function getModelClassname()
    {
        return $this->model;
    }

    protected function getModel()
    {
        return app($this->getModelClassname());
    }

    public function create()
    {
        $this->authorize('create', $this->getModelClassname());

        return view($this->getModuleView().'.form');
    }

    public function show($id)
    {
        $data = $this->getModel()::where('id', $id)->firstOrFail();

        $this->authorize('view', $data);

        return view($this->getModuleView().'.show', [
            $this->getCompactname() => $data,
        ]);
    }

    public function edit($id)
    {
        $data = $this->getModel()::where('id', $id)->firstOrFail();

        $this->authorize('update', $data);

        return view($this->getModuleView().'.form', [
            $this->getCompactname() => $data,
        ]);
    }

    public function destroy($id)
    {
        $data = $this->getModel()::where('id', $id)->firstOrFail();

        $indexUrl = $data->getResourceUrl();

        $this->authorize('delete', $data);

        $data->delete();

        return redirect()->to($indexUrl);
    }
}
