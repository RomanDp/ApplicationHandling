<?php

namespace AppBundle\Service;

use AppBundle\Entity\Application;
use AppBundle\Model\ApplicationHandlingDTO;
use Doctrine\Bundle\DoctrineBundle\Registry;
use FOS\UserBundle\Model\UserManager;

class Companies
{

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @param Registry $doctrine
     * @param UserManager $userManager
     */
    public function __construct(Registry $doctrine, UserManager $userManager)
    {
        $this->doctrine = $doctrine;
        $this->userManager = $userManager;
    }


    /**
     * @param ApplicationHandlingDTO $dto
     * @param Application $application
     */
    public function addToCompanyFilledPersonsFromDto(ApplicationHandlingDTO $dto, Application $application)
    {
        $em = $this->doctrine->getManager();
        foreach ($dto->targetParticipants as $targetParticipant) {

            if (!$targetParticipant->targetPerson->getApplication()) {
                $targetParticipant->targetPerson->setApplication($application);
            }

            if (!$targetParticipant->targetPerson->getLocale()) {
                $targetParticipant->targetPerson->setLocale(mb_strtolower($application->getLanguage()));
            }

            $dto->targetCompany->addPerson($targetParticipant->targetPerson);

            // set participant data from person
            $targetParticipant->targetParticipant->populatetFromPerson($targetParticipant->targetPerson);

            $targetParticipant->targetPerson->setUsername($targetParticipant->targetPerson->getEmail());
            $this->userManager->updateUser($targetParticipant->targetPerson, false);

            $em->persist($targetParticipant->targetParticipant);
        }

    }
}