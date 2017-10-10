<?php

use Framework\Modules\Contact\ContactModule;
use Framework\Twig\MenuTwigExtension;

return [
    'home.prefix' => '/',
    'homeModules' => [
        \DI\get(ContactModule::class)
    ],
    MenuTwigExtension::class => Di\object()->constructor(Di\get("homeModules")),
];
