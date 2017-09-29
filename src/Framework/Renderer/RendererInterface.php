<?php

namespace Framework\Renderer;

interface RendererInterface
{
    /**
     * Add view to namespace
     * @param string $namespace
     * @param null|string $path
     */
    public function addPath(string $namespace, ?string $path = null): void;

    /**
     * Render a view
     * Namespace can be specified via addPath();
     * $this->reder('@blog/view');
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render(string $view, array $params = []): string;

    /**
     * Add global ariables to all vues
     * @param string $key
     * @param mixed $value
     */
    public function addGlobal(string $key, $value): void;
}
