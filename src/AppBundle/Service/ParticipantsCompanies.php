<?php

namespace AppBundle\Service;

use AppBundle\Entity\ApplicationParticipationType;
use AppBundle\Entity\Conference;
use AppBundle\Entity\ParticipantCompany;
use Doctrine\ORM\EntityManager;

class ParticipantsCompanies
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager   $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param ApplicationParticipationType[] $applicationParticipationTypes
     * @param Conference $conference
     */
    public function createParticipantsCompaniesByAdditionalTypes(
        array $applicationParticipationTypes,
        Conference $conference
    ) {
        foreach ($applicationParticipationTypes as $additionalType) {
            $participantCompany = new ParticipantCompany();
            $participantCompany->setParticipationType($additionalType->getParticipationType());
            $participantCompany->setConference($conference);
            $this->em->persist($participantCompany);
        }
        $this->em->flush();
    }
}