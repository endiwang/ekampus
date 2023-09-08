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

        return $this->getUrlPrefix().str(get_called_class())->classBasename()->kebab()->plural()->toString();
    }

    public function getUrlPrefix()
    {
        if(property_exists($this, 'urlPrefix')) {
            return rtrim($this->urlPrefix, '.') . '.';
        }

        return '';
    }
}
