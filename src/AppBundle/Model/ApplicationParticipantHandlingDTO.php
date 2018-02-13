<?php

namespace AppBundle\Model;

use AppBundle\Entity\ApplicationParticipant;
use AppBundle\Entity\Participant;
use AppBundle\Entity\Person;
use Symfony\Component\Validator\Constraints as Assert;

class ApplicationParticipantHandlingDTO
{
    /**
     * @var Person
     * @Assert\Valid()
     */
    public $targetPerson;

    /**
     * @var Participant
     * @Assert\Valid()
     */
    public $targetParticipant;

    public static $personFields = [
        'firstNameRu',
        'firstNameUk',
        'firstNameEn',
        'lastNameRu',
        'lastNameUk',
        'lastNameEn',
        'positionRu',
        'positionUk',
        'positionEn',
        'email',
        'phone',
    ];

    public function __construct(ApplicationParticipant $applicationParticipant)
    {
        $this->targetPerson = $applicationParticipant->getPerson() ?: new Person();

        $this->targetParticipant = new Participant();

        $participantFields = [
            //'conference',
            'person',
            'participationType' => 'type',
            'email',
            'phone',
        ];

        ApplicationHandlingDTO::mergeData($this->targetParticipant, $applicationParticipant, $participantFields);
        ApplicationHandlingDTO::mergeData($this->targetPerson, $applicationParticipant, self::$personFields);
    }
}
