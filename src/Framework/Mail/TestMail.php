<?php

namespace Framework\Mail;


/**
 * Class TestMail - Return mails to logs for test purpose
 * @package Framework\Mail
 */
class TestMail implements MailInterface
{

    /**
     * @var string
     */
    private $host;
    /**
     * @var int
     */
    private $port;
    /**
     * @var bool|null
     */
    private $isDebug;
    /**
     * @var bool|null
     */
    private $isSMTP;
    /**
     * @var bool|null
     */
    private $isSMTPAuth;
    /**
     * @var null|string
     */
    private $username;
    /**
     * @var null|string
     */
    private $password;
    /**
     * @var null|string
     */
    private $SMTPSecure;

    /**
     * @var string
     */
    private $fromEmail;

    /**
     * @var ? string
     */
    private $fromName;

    /**
     * @var [string, string]
     */
    private $recipients;

    /**
     * @var [string, string]
     */
    private $replyTo;

    /**
     * @var string[]
     */
    private $CCC;

    /**
     * @var string[]
     */
    private $BCC;

    /**
     * @var [string, ? string]
     */
    private $attachments;

    /**
     * @var bool
     */
    private $isHTML;

    /**
     * @var string
     */
    private $body;

    public function __construct()
    {
        $this->config();
    }

    /**
     * Set the server configuration
     *
     * @param string $host
     * @param int $port
     * @param bool|null $isDebug
     * @param bool|null $isSMTP
     * @param bool|null $isSMTPAuth
     * @param null|string $username
     * @param null|string $password
     * @param null|string $SMTPSecure
     */
    public function config(string $host = "localhost", int $port = 25, ? bool $isDebug = false, ? bool $isSMTP = true, ? bool $isSMTPAuth = true, ? string $username = "", ? string $password = "", ? string $SMTPSecure = "tls"): void
    {
        $this->host = $host;
        $this->port = $port;
        $this->isDebug = $isDebug;
        $this->isSMTP = $isSMTP;
        $this->isSMTPAuth = $isSMTPAuth;
        $this->username = $username;
        $this->password = $password;
        $this->SMTPSecure = $SMTPSecure;
    }

    /**
     * Specify From
     *
     * @param string $email
     * @param null|string $name
     * @return MailInterface
     */
    public function setFrom(string $email, ? string $name): MailInterface
    {
        $this->fromEmail = $email;
        $this->fromName = $email;
    }

    /**
     * Add adresse to recipient list
     *
     * @param string $email
     * @param null|string $name
     * @return MailInterface
     */
    public function addAddress(string $email, ? string $name): MailInterface
    {
        $this->recipients[] = [
            $email,
            $name
        ];
    }

    /**
     * Add adresse to reply to list
     *
     * @param string $email
     * @param null|string $name
     * @return MailInterface
     */
    public function addReplyTo(string $email, ? string $name): MailInterface
    {
        $this->replyTo[] = [
            $email,
            $name
        ];
    }

    /**
     * Add CCC
     *
     * @param string $email
     * @return MailInterface
     */
    public function addCCC(string $email): MailInterface
    {
        $this->CCC[] = [
            $email
        ];
    }

    /**
     * Add BCC
     *
     * @param string $email
     * @return MailInterface
     */
    public function addBCC(string $email): MailInterface
    {
        $this->BCC[] = [
            $email
        ];
    }

    /**
     * Add attachment from a path
     *
     * @param string $path
     * @param null|string $name
     * @return MailInterface
     */
    public function addAttachment(string $path, ? string $name = null): MailInterface
    {
        $this->attachments[] = [
            $path,
            $name
        ];
    }

    /**
     * Set is mail should return html, or not
     *
     * @param bool $isHTML
     * @return MailInterface
     */
    public function isHTML(bool $isHTML): MailInterface
    {
        $this->isHTML = $isHTML;
    }

    /**
     * Set is mail should return html, or not
     *
     * @param string $subject
     * @return MailInterface
     */
    public function subject(string $subject): MailInterface
    {
        $this->subject = $subject;
    }

    /**
     * Set is mail should return html, or not
     *
     * @param string $body
     * @return MailInterface
     */
    public function body(string $body): MailInterface
    {
        $this->body = $body;
    }

    /**
     * Set is mail should return html, or not
     * @param string $altBody
     * @return MailInterface
     */
    public function altBody(string $altBody): MailInterface
    {
        $this->body = $altBody;
    }

    public function send()
    {

    }
}
