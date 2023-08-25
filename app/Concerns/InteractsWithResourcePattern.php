<?php

namespace App\Concerns;

trait InteractsWithResourcePattern
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
}
