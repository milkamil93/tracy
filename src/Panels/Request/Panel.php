<?php namespace YesTracy\Panels\Request;

use YesTracy\Panels\AbstractPanel;

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
            'server' => $_SERVER,
            'cookies' => $_COOKIE,
            'get' => $_GET,
            'post' => $_POST
        ];
        return compact('rows');
    }
}
