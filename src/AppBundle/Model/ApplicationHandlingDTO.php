<?php

namespace AppBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Entity\Application;
use AppBundle\Entity\ApplicationParticipationType;
use AppBundle\Entity\Company;

class ApplicationHandlingDTO
{

    /**
     * @var Company
     */
    public $company;

    /**
     * @var string
     */
    public $currencyName;

    /**
     * @var Company
     * @Assert\Valid()
     */
    public $targetCompany;

    /**
     * @var ApplicationParticipationType[]
     */
    public $targetApplicationParticipationType;

    /**
     * @var ApplicationParticipantHandlingDTO[]
     * @Assert\Valid()
     */
    public $targetParticipants = [];

    /**
     * @var Application
     */
    public $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
        //Бывает в том случает, если у нас была валюта сначала, потом мы её удалил, то всем
        // application у кого была выбрана эта валюта проставится null в валюте.
        $this->currencyName = $application->getCurrency() ? $application->getCurrency()->getName() : 'Не выбрана';
        $this->company = $application->getCompany();
        $this->targetCompany = $application->getCompany() ?: new Company();
        $this->targetApplicationParticipationType = $application->getAdditionalApplicationParticipationTypes();

        $fields = [
            'nameRu',
            'nameUk',
            'nameEn',
            'crmId',
            'director',
            'activitiesEn',
            'activitiesUk',
            'activitiesRu',
            'contact',
            'phone',
            'email',
            'addressUk',
            'addressRu',
            'addressEn',
            'legalCompanyName',
            'country',
            'legalAddress',
            'mailAddress',
            'legalId',
            'taxId',
        ];

        self::mergeData($this->targetCompany, $application, $fields);

        foreach ($application->getApplicationParticipants() as $applicationParticipant) {
            $this->targetParticipants[] = new ApplicationParticipantHandlingDTO($applicationParticipant);
        }
    }

    public static function mergeData($target, $source, array $fields)
    {
        foreach ($fields as $sourceField => $targetField) {
            if (is_numeric($sourceField)) {
                $sourceField = $targetField;
            }

            $valueSource = $source->{'get' . $sourceField}();
            $valueTarget = $target->{'get' . $targetField}();

            if ($valueSource && !$valueTarget) {
                $target->{'set' . $targetField}($valueSource);
            }
        }
    }

    /**
     * @Assert\Callback(groups={"ApplicationParticipants"})
     */
    public function ensureParticipantsHasUniqueCrmId(ExecutionContextInterface $executionContext, $payload)
    {
        $usedCrmIds = [];

        foreach ($this->targetParticipants as $i => $targetParticipant) {
            $crmId = $targetParticipant->targetParticipant->getCrmId();

            if (!$crmId) {
                continue;
            }

            if (isset($usedCrmIds[$crmId])) {
                $executionContext
                    ->buildViolation('Участник уже зарегистрирован')
                    ->atPath(sprintf('targetParticipants[%s].targetParticipant.crmId', $i))
                    ->addViolation();
            }

            $usedCrmIds[$crmId] = true;
        }
    }

    /**
     * @Assert\Callback(groups={"ApplicationParticipants"})
     */
    public function ensureParticipantsHasUniquePerson(ExecutionContextInterface $executionContext, $payload)
    {
        $usedPersons = new \SplObjectStorage();

        foreach ($this->targetParticipants as $i => $targetParticipant) {

            if ($usedPersons->contains($targetParticipant->targetPerson)) {
                $executionContext
                    ->buildViolation('Данный сотрудник уже выбран')
                    ->atPath(sprintf('targetParticipants[%s].targetParticipant.person', $i))
                    ->addViolation();
            }

            $usedPersons->attach($targetParticipant->targetPerson);
        }
    }
}
