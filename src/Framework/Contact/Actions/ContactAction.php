<?php

namespace Framework\Modules\Contact\Actions;


use Framework\Renderer\RendererInterface;
use GuzzleHttp\Psr7\Request;

class ContactAction
{
    /**
     * ContactAction constructor.
     * @param RendererInterface $renderer
     */
    public function __construct(RendererInterface $renderer)
    {

    }

    public function __invoke(Request $request)
    {
        return $this->index($request);
    }

    public function index(Request $request): string
    {
        var_dump("ok");
        return $this->renderer->render('@blog/index', compact('posts'));
    }

}
