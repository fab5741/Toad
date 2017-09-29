<?php

namespace App\Blog\Actions;

use App\Blog\Table\CategoryTable;
use App\Blog\Table\PostTable;
use Framework\Actions\CrudAction;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Framework\Session\FlashService;
use Psr\Http\Message\ServerRequestInterface as Request;

class CategoryCrudActions extends CrudAction
{
    protected $viewPath = "@blog/admin/categories";

    protected $routePrefix = "blog.category.admin";

    /**
     * PostCrudActions constructor.
     * @param RendererInterface $renderer
     * @param Router $router
     * @param CategoryTable|PostTable $table
     * @param FlashService $flash
     * @internal param FlashService $flashService
     */
    public function __construct(RendererInterface $renderer, Router $router, CategoryTable $table, FlashService $flash)
    {
        parent::__construct($renderer, $router, $table, $flash);
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function getParams(Request $request, $item = null): array
    {
        return array_filter($request->getParsedBody(), function ($key) {
            return in_array($key, ['name', 'slug']);
        }, ARRAY_FILTER_USE_KEY);
    }

    protected function getValidator(Request $request)
    {
        return (parent::getValidator($request))
            ->required('name', 'slug')
            ->length('name', 2, 250)
            ->length('slug', 2, 50)
            ->unique('slug', $this->table->getTable(), $this->table->getPdo(), $request->getAttribute('id'))
            ->slug('slug');
    }
}
