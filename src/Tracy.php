<?php

namespace YesTracy;

use Tracy\Debugger;
use Tracy\IBarPanel;
use YesTracy\Panels\AbstractPanel;

class Tracy
{
    public static function init()
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
            self::injectPanel(new $panel);
        }
    }

    public static function injectPanel(IBarPanel $panel)
    {
        if (is_a($panel, AbstractPanel::class)) {
            $panel->setLaravel();
        }
        Debugger::getBar()->addPanel($panel);
    }
}