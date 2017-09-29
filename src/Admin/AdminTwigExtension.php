<?php

namespace App\Admin;

use Twig_SimpleFunction;

class AdminTwigExtension extends \Twig_Extension
{
    /**
     * @var array
     */
    private $widgets;

    public function __construct(array $widgets)
    {
        $this->widgets = $widgets;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction("admin_menu", [$this, 'renderMenu'], ['is_safe' => ['html']])
        ];
    }

    public function renderMenu(): string
    {
        return array_reduce($this->widgets, function (string $html, AdminWidgetInterface $widget) {
            return $html . $widget->renderMenu();
        }, '');
    }
}
