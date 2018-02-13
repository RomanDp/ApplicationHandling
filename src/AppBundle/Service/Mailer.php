<?php

namespace AppBundle\Service;

class Mailer
{
    private $mailer;

    private $twig;

    private $fromEmail;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig, array $fromEmail)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->fromEmail = $fromEmail;
    }

    /**
     * @param string $templateName #twig.files
     * @param string|array $toEmail
     * @param array $context
     * @param null|string|array $fromEmail
     * @param null|string|array $replyTo
     */
    public function sendMessage($templateName, $toEmail, array $context = array(), $fromEmail = null, $replyTo = null)
    {
        $message = $this->prepareMessage($templateName, $toEmail, $context, $fromEmail, $replyTo);
        $this->mailer->send($message);
    }

    /**
     * @param string $templateName #twig.files
     * @param string|array $toEmail
     * @param array $context
     * @param null|string|array $fromEmail
     * @param null|string|array $replyTo
     *
     * @return \Swift_Message
     */
    public function prepareMessage($templateName, $toEmail, array $context = array(), $fromEmail = null, $replyTo = null)
    {
        $context = $this->twig->mergeGlobals($context);
        $context['recipient'] = is_array($toEmail) ? key($toEmail) : $toEmail;
        $template = $this->twig->load($templateName);
        $subject = $template->renderBlock('subject', $context);
        $textBody = $template->renderBlock('body_text', $context);
        $htmlBody = $template->renderBlock('body_html', $context);

        /** @var $message \Swift_Message */
        $message = $this
            ->mailer
            ->createMessage()
            ->setSubject($subject)
            ->setFrom($fromEmail ?: $this->fromEmail)
            ->setTo($toEmail);


        if ($replyTo) {
            $message->setReplyTo($replyTo);
        }

        if (!empty($htmlBody)) {
            $message
                ->setBody($htmlBody, 'text/html')
                ->addPart($textBody, 'text/plain');
        } else {
            $message->setBody($textBody);
        }

        return $message;
    }
}