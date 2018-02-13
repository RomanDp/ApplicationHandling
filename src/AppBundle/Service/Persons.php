<?php

namespace AppBundle\Service;

use AppBundle\Entity\Application;
use AppBundle\Entity\Person;
use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Util\TokenGeneratorInterface;

class Persons
{
    /**
     * @var TokenGeneratorInterface
     */
    private $tokenGenerator;

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @var string
     */
    private $fromEmail;

    /**
     * @var Mailer
     */
    private $mailerService;

    /**
     * Persons constructor.
     * @param TokenGeneratorInterface $tokenGenerator
     * @param UserManager $userManager
     * @param Mailer $mailer
     * @param string $fromEmail
     */
    public function __construct(
        TokenGeneratorInterface $tokenGenerator,
        UserManager $userManager,
        Mailer $mailer,
        $fromEmail
    ) {
        $this->tokenGenerator = $tokenGenerator;
        $this->userManager = $userManager;
        $this->mailerService = $mailer;
        $this->fromEmail = $fromEmail;
    }

    /**
     * @param Person $person
     */
    public function createConfirmationToken(Person $person = null)
    {
        if ($person && null === $person->getConfirmationToken()) {
            /** @var $tokenGenerator TokenGeneratorInterface */
            $person->setConfirmationToken($this->tokenGenerator->generateToken());
            $person->setPasswordRequestedAt(new \DateTime());
            $this->userManager->updateUser($person);
        }
    }

    /**
     * @param Person[] $personsToSend
     * @param Application $application
     */
    public function sendNotificationPersonsAboutNewConference(array $personsToSend, Application $application)
    {
        foreach ($personsToSend as $person) {
            $isApprovedPerson = $person->getPassword();
            if (!$isApprovedPerson) {
                $this->createConfirmationToken($person);
            }

            $this->mailerService->sendMessage(
                'applications/emails/notify-participant-new-conference.html.twig',
                $person->getEmail(),
                [
                    'application' => $application,
                    'isApprovedPerson' => $isApprovedPerson,
                    'person' => $person
                ],
                $this->fromEmail
            );
        }
    }
}
