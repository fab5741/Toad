<?php

namespace App\Modules\Contact;

use Framework\Modules\Contact\ContactModule;
use Psr\Container\ContainerInterface;

class MyContactModule extends ContactModule
{
    const DEFINITIONS = __DIR__ . "/config.php";

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }
}
