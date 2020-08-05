## Установка
```
composer require milkamil93/tracy
```
##### и php
```
use Tracy\Debugger;
use YesTracy\Tracy;

Debugger::enable(false);
Debugger::$showBar = true;
Debugger::dispatch();
Tracy::init();
```