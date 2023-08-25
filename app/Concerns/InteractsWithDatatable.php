<?php

namespace App\Concerns;

trait InteractsWithDatatable
{
    protected function getActionView(): string
    {
        if (property_exists($this, 'actionView')) {
            return $this->actionView;
        }

        return 'partials.datatable-action';
    }
}
