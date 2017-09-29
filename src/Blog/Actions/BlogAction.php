<?php

namespace App\Blog\Actions;

use App\Blog\Table\CategoryTable;
use App\Blog\Table\PostTable;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stdlib\ResponseInterface;

class BlogAction
{
    /**
     * @var RendererInterface
     */
    private $renderer;


    /**
     * @var Router
     */
    private $router;

    /**
     * @var PostTable
     */
    private $postTable;
    /**
     * @var CategoryTable
     */
    private $categoryTable;

    use RouterAwareAction;

    public function __construct(
        RendererInterface $renderer,
        Router $router,
        PostTable $postTable,
        CategoryTable $categoryTable
    )
    {

        $this->renderer = $renderer;
        $this->router = $router;
        $this->postTable = $postTable;
        $this->categoryTable = $categoryTable;
    }

    public function __invoke(Request $request)
    {
        if ($request->getAttribute("id")) {
            return $this->show($request);
        } else {
            return $this->index($request);
        }
    }

    /**
     * Display an article
     *
     * @param Request $request
     * @return ResponseInterface|string
     *
     */
    public function show(Request $request)
    {
        $slug = $request->getAttribute('slug');
        $post = $this->postTable->find($request->getAttribute(('id')));

        if ($post->slug !== $slug) {
            return $this->redirect("blog.show", [
                'slug' => $post->slug,
                'id' => $post->id,
            ]);
        }
        return $this->renderer->render('@blog/show', [
            'post' => $post,
        ]);
    }

    public function index(Request $request): string
    {
        $params = $request->getQueryParams();
        $posts = $this->postTable->findPaginatedPublic(12, $params['p'] ?? 1);

        return $this->renderer->render('@blog/index', compact('posts'));
    }
}
