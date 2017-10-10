<?php

namespace App\Modules\Home\Actions;

use Framework\Renderer\RendererInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

class IndexAction
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * IndexAction constructor.
     * @param ContainerInterface $container
     * @param RendererInterface $renderer
     * @internal param MailInterface $mail
     * @internal param FlashService $flash
     */
    public function __construct(
        ContainerInterface $container,
        RendererInterface $renderer
    ) {
        $this->container = $container;
        $this->renderer = $renderer;
    }

    public function __invoke(Request $request)
    {
        return $this->renderer->render('@home/index');
    }
}
