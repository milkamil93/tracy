<?php namespace YesTracy\Panels\Routing;

use Illuminate\Support\Arr;
use YesTracy\Panels\AbstractPanel;
use ManagerTheme;

class Panel extends AbstractPanel
{
    /**
     * getAttributes.
     *
     * @return array
     */
    protected function getAttributes()
    {
        $rows = [
            'uri' => 404,
        ];
        if ($this->hasLaravel() === true) {
            $router = $this->laravel['router'];
            $currentRoute = $router->getCurrentRoute();
            if (is_null($currentRoute) === false) {
                $rows = array_merge([
                    'uri' => $currentRoute->uri(),
                ], $currentRoute->getAction());
            }
        } else {
            $rows['uri'] = empty(Arr::get($_SERVER, 'HTTP_HOST')) === true ?
                404 : Arr::get($_SERVER, 'REQUEST_URI');
        }

        return compact('rows');
    }
}
