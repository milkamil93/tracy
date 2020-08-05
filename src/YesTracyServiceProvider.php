<?php

namespace YesTracy;

use Illuminate\Support\ServiceProvider;
use Tracy\Debugger;

class YesTracyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Debugger::enable(false);
        Debugger::$showBar = false;
        Debugger::$strictMode = true;
    }
}