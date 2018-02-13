<?php

namespace AppBundle\Service;

use AppBundle\Entity\Person;

class UserMailer
{
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * @var string
     */
    private $emailFrom;

    public function __construct(Mailer $mailer, $emailFrom)
    {
        $this->mailer = $mailer;
        $this->emailFrom = $emailFrom;
    }

    public function sendChangeEmail(Person $user)
    {
        try {
            $this->mailer->sendMessage(
                'profile/emails/change_email.html.twig',
                $user->getNewEmail(),
                ['user' => $user],
                $this->emailFrom
            );
        } catch (\Swift_RfcComplianceException $e) {
        }
    }

}
