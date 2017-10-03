<?php

namespace Framework\Modules\Contact\Actions;

use App\Blog\Table\CategoryTable;
use App\Blog\Table\PostTable;
use Framework\Actions\RouterAwareAction;
use Framework\Mail\MailInterface;
use Framework\Renderer\RendererInterface;
use Framework\Validator;
use Psr\Container\ContainerInterface;
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
    /**
     * @var ContainerInterface
     */
    private $container;

    use RouterAwareAction;

    /**
     * IndexAction constructor.
     * @param ContainerInterface $container
     * @param RendererInterface $renderer
     * @param MailInterface $mail
     */
    public function __construct(ContainerInterface $container, RendererInterface $renderer, MailInterface $mail)
    {
        $this->container = $container;
        $this->renderer = $renderer;
        $this->mail = $mail;
    }

    public function __invoke(Request $request)
    {
        if ($request->getMethod() === "POST") {
            $validator = $this->getValidator($request);
            if ($validator->isValid()) {
                $this->mail->config("localhost", 25, true, true, true, "root", "", "tls");

                $this->mail->setFrom($this->container->get("from"), "test");
                $this->mail->addAddress($this->container->get("to"), "test");

                $body = "Name : " . $request->getParsedBody()['name'] . "\n";
                $body .= "Email : " . $request->getParsedBody()['email'] . "\n";
                $body .= "Message : " . $request->getParsedBody()['message'] . "\n";

                $this->mail->body($body);

                $this->mail->send();
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
