<?php

use App\Admin\AdminModule;
use App\Admin\DashboardAction;

return [
    'admin.prefix' => '/admin',
    'admin.widgets' => [],

    \App\Admin\AdminTwigExtension::class => Di\object()->constructor(Di\get("admin.widgets")),
    AdminModule::class => Di\Object()->constructorParameter('prefix', Di\get('admin.prefix')),
    DashboardAction::class => Di\Object()->constructorParameter('widgets', Di\get('admin.widgets')),
];
