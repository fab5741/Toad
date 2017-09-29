<?php

namespace App\Blog\Actions;

use App\Blog\Entity\Post;
use App\Blog\PostUpload;
use App\Blog\Table\CategoryTable;
use App\Blog\Table\PostTable;
use Framework\Actions\CrudAction;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Framework\Session\FlashService;
use Psr\Http\Message\ServerRequestInterface as Request;

class PostCrudActions extends CrudAction
{
    protected $viewPath = "@blog/admin/posts/";

    protected $routePrefix = "blog.admin";
    /**
     * @var CategoryTable
     */
    private $categoryTable;
    /**
     * @var PostUpload
     */
    private $postUpload;

    /**
     * PostCrudActions constructor.
     * @param RendererInterface $renderer
     * @param Router $router
     * @param PostTable $table
     * @param FlashService $flash
     * @param CategoryTable $categoryTable
     * @param \App\Blog\PostUpload $postUpload
     * @internal param FlashService $flashService
     */
    public function __construct(
        RendererInterface $renderer,
        Router $router,
        PostTable $table,
        FlashService $flash,
        CategoryTable $categoryTable,
        PostUpload $postUpload
    )
    {
        parent::__construct($renderer, $router, $table, $flash);
        $this->categoryTable = $categoryTable;
        $this->postUpload = $postUpload;
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return array
     */
    protected function getParams(Request $request, $post = null): array
    {
        $params = array_merge($request->getParsedBody(), $request->getUploadedFiles());
        //upload files
        $params['image'] = $this->postUpload->upload($params['image'], $post->image);

        $params = array_filter($params, function ($key) {
            return in_array($key, ['name', 'slug', 'content', "created_at", 'category_id', 'image']);
        }, ARRAY_FILTER_USE_KEY);
        return array_merge($params, ['updated_at' => date('Y-m-d H:i:s')]);
    }

    protected function getValidator(Request $request)
    {
        $validator = (parent::getValidator($request))
            ->required('content', 'name', 'slug', "created_at", "category_id")
            ->length('content', 10)
            ->length('name', 2, 250)
            ->length('slug', 2, 50)
            ->dateTime("created_at")
            ->exists('category_id', $this->categoryTable->getTable(), $this->categoryTable->getPdo())
            ->slug('slug')
            ->uploaded('image')
            ->extension('image', ['jpg', 'jpeg', 'png']);
        if (is_null($request->getAttribute("id"))) {
            $validator->required("image");
        }
        return $validator;
    }

    protected function formParams(?array $params): array
    {
        $params['categories'] = $this->categoryTable->findList();
        $params['categories']["121515151"] = "Categorie Fake";
        return $params;
    }

    protected function getNewEntity()
    {
        $post = new Post;
        $post->created_at = new \DateTime();
        return $post;
    }
}
