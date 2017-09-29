<?php

namespace App\Blog\Actions;

use App\Blog\Table\CategoryTable;
use App\Blog\Table\PostTable;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

class PostIndexAction
{
    /**
     * @var RendererInterface
     */
    private $renderer;


    public function __construct(RendererInterface $renderer)
    {

        $this->renderer = $renderer;
    }

    public function __invoke(Request $request)
    {
        return $this->renderer->render('@blog/index');
    }
}
