<?php

namespace Framework\Twig;

use Twig_SimpleFunction;

class MenuTwigExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction("main_menu", [$this, 'renderMenu'], ['is_safe' => ['html']])
        ];
    }

    public function renderMenu(): string
    {
        //TODO : add the menu.twig of each modules
        return "ok";
    }
}
