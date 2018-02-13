<?php

namespace AppBundle\Service;

use AppBundle\Entity\Company;
use AppBundle\Entity\CompanyConferenceDetail;
use AppBundle\Entity\Conference;
use AppBundle\Model\ApplicationHandlingDTO;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use Brouzie\Mailer\Mailer;

class Participants
{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * Participants constructor.
     *
     * @param Registry        $doctrine
     * @param Mailer          $mailer
     */
    public function __construct(Registry $doctrine, Mailer $mailer)
    {
        $this->em = $doctrine->getManager();
        $this->mailer = $mailer;
    }

    /**
     * @param ApplicationHandlingDTO $dto
     * @param Conference $conference
     */
    public function setCompanyConferenceDetails(ApplicationHandlingDTO $dto, Conference $conference)
    {
        $companyConferenceDetail = $this->getCompanyConferenceDetail($dto->targetCompany, $conference);
        $companyConferenceDetail->setData($dto->targetCompany, $conference);
        foreach ($dto->targetParticipants as $targetParticipant) {
            $targetParticipant->targetParticipant->setCompanyConferenceDetail($companyConferenceDetail);
        }

        $this->em->flush();
    }

    /**
     * @param Company $company
     * @param Conference $conference
     * @return CompanyConferenceDetail
     */
    private function getCompanyConferenceDetail(Company $company, Conference $conference)
    {
        $companyConferenceDetail = $this->em
            ->getRepository('AppBundle:CompanyConferenceDetail')
            ->findOneBy([
                'company' => $company,
                'conference' => $conference,
            ]);

        if (null === $companyConferenceDetail) {
            $companyConferenceDetail = new CompanyConferenceDetail();
            $this->em->persist($companyConferenceDetail);
        }

        return $companyConferenceDetail;
    }
}
