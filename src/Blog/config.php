<?php

/**
 * Configuration for the Blog - Overwrite the /config/config.php
 */

use function DI\get;

return [
    'blog.prefix' => '/blog',
    'admin.widgets' => Di\add([
        get(\App\Blog\BlogWidget::class),
    ]),
];
