<?php

namespace YesTracy;

use Illuminate\Support\ServiceProvider;
use Tracy\Debugger;
use Tracy\IBarPanel;
use Panels\AbstractPanel;

class YesTracyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (env('APP_DEBUG'))
        {
            $panels = [
                Panels\Database\Panel::class,
                Panels\Routing\Panel::class,
                Panels\Request\Panel::class,
                Panels\Session\Panel::class,
                Panels\Event\Panel::class,
                Panels\View\Panel::class,
                Panels\Auth\Panel::class
            ];
            foreach ($panels as $panel) {
                $this->injectPanel(new $panel);
            }
        }
    }

    private function injectPanel(IBarPanel $panel): void
    {
        if (is_a($panel, AbstractPanel::class)) {
            $panel->setLaravel();
        }
        Debugger::getBar()->addPanel($panel);
    }

    public function register()
    {

    }
}