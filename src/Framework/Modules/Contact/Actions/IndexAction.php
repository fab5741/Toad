<?php

namespace Framework\Modules\Contact\Actions;

use App\Blog\Table\CategoryTable;
use App\Blog\Table\PostTable;
use Framework\Actions\RouterAwareAction;
use Framework\Mail\MailInterface;
use Framework\Renderer\RendererInterface;
use Framework\Validator;
use Psr\Http\Message\ServerRequestInterface as Request;

class IndexAction
{
    /**
     * @var RendererInterface
     */
    private $renderer;
    /**
     * @var MailInterface
     */
    private $mail;

    use RouterAwareAction;

    /**
     * IndexAction constructor.
     * @param RendererInterface $renderer
     * @param MailInterface $mail
     */
    public function __construct(RendererInterface $renderer, MailInterface $mail)
    {

        $this->renderer = $renderer;
        $this->mail = $mail;
    }

    public function __invoke(Request $request)
    {
        // test mail
        var_dump($this->mail);
        exit(0);
        if ($request->getMethod() === "POST") {
            $validator = $this->getValidator($request);
            if ($validator->isValid()) {
                //TODO : send an email
                var_dump("ok");
                exit(0);
                //TODO :  flash success message

            }
            $errors = $validator->getErrors();
            //TODO : Display error

        }
        return $this->renderer->render('@contact/index');
    }

    protected function getValidator(Request $request)
    {
        $request->getUploadedFiles();
        return new Validator(array_merge($request->getParsedBody(), $request->getUploadedFiles()));
    }
}
