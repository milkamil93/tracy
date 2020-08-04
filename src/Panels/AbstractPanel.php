<?php namespace YesTracy\Panels;

use Tracy\Helpers;
use Tracy\IBarPanel;
use YesTracy\Template;

/**
 * @see: https://github.com/recca0120/laravel-tracy
 */
abstract class AbstractPanel implements IBarPanel
{

    protected $attributes;

    protected $viewPath = null;

    protected $template;

    protected $laravel;

    public function __construct(Template $template = null)
    {
        $this->template = $template ?: new Template;
    }

    public function setLaravel()
    {
        $this->laravel = app();

        if ($this->hasLaravel() === true && $this->hasSubscribeMethod()) {
            $this->subscribe();
        }

        return $this;
    }

    public function getTab()
    {
        return $this->render('tab');
    }

    public function getPanel()
    {
        return $this->render('panel');
    }

    protected function hasSubscribeMethod()
    {
        return method_exists($this, 'subscribe');
    }

    protected function hasLaravel()
    {
        return !!$this->laravel;
    }

    protected function render($view)
    {
        $view = $this->getViewPath().$view.'.php';
        if (empty($this->attributes) === true) {
            $this->template->setAttributes(
                $this->attributes = $this->getAttributes()
            );
        }

        return $this->template->render($view);
    }

    public function getViewPath()
    {
        if ($this->viewPath !== null) {
            return $this->viewPath;
        }

        $class_info = new \ReflectionClass($this);
        return $this->viewPath = dirname($class_info->getFileName()) . '/assets/';
    }

    abstract protected function getAttributes();

    protected static function findSource()
    {
        $source = '';
        $trace = debug_backtrace(PHP_VERSION_ID >= 50306 ? DEBUG_BACKTRACE_IGNORE_ARGS : false);
        foreach ($trace as $row) {
            if (isset($row['file']) === false) {
                continue;
            }

            if (isset($row['function']) === true && strpos($row['function'], 'call_user_func') === 0) {
                continue;
            }

            if (isset($row['class']) === true && (
                    is_subclass_of($row['class'], '\Tracy\IBarPanel') === true ||
                    strpos(str_replace('/', '\\', $row['file']), 'Illuminate\\') !== false
                )) {
                continue;
            }

            $source = [$row['file'], (int) $row['line']];
        }

        return $source;
    }

    protected static function editorLink($source)
    {
        if (is_string($source) === true) {
            $file = $source;
            $line = null;
        } else {
            $file = $source[0];
            $line = $source[1];
        }

        return Helpers::editorLink($file, $line);
    }
}