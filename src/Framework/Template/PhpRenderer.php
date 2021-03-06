<?php


namespace Framework\Template;

use Framework\Http\Router\Router;

class PhpRenderer implements TemplateRenderer
{
    private $path;
    //private $params = [];
    private $extend;
    private $blocks = [];
    private $blockNames;
    private $router;

    public function __construct($path, Router $router)
    {
        $this->path = $path;
        $this->blockNames = new \SplStack();
        $this->router = $router;
    }

    public function render($view, array $blocks = []): string
    {
        $templateFile = $this->path . '/' . $view . '.php';

        ob_start();
        extract($blocks, EXTR_OVERWRITE);
        $blocks = [];
        $this->extend = null;
        require $templateFile;
        $content = ob_get_clean();

        if (!$this->extend) {
            return $content;
        }
        return $this->render($this->extend);
    }

    public function extend($view): void
    {
        $this->extend = $view;
    }

    public function beginBlock($name): void
    {
        $this->blockNames->push($name);
        ob_start();
    }

    public function endBlock()
    {
        $content =  ob_get_clean();
        $name = $this->blockNames->pop();
        if ($this->hasBlock($name)) {
            return;
        }
        $this->blocks[$name] = $content;
    }

    public function renderBlock($name): string
    {
        $block = $this->blocks[$name] ?? null;

        if ($block instanceof \Closure) {
            return $block();
        }

        return $block ?? '';
    }

    private function hasBlock($name): bool
    {
        return array_key_exists($name, $this->blocks);
    }

    public function ensureBlock($name): bool
    {
        if ($this->hasBlock($name)) {
            return false;
        }
        $this->beginBlock($name);
        return true;
    }

    public function block($name, $content): void
    {
        if ($this->hasBlock($name)) {
            return;
        }
        $this->blocks[$name] = $content;
    }

    public function encode($string): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE);
    }

    public function path($name, array $params = []): string
    {
        return $this->router->generate($name, $params);
    }
}