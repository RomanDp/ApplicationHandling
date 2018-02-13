<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Table(
 *     name="company_conference_details",
 *     uniqueConstraints={@ORM\UniqueConstraint(columns={"company_id", "conference_id"})}
 * )
 * @ORM\Entity()
 * @UniqueEntity(fields={"company", "conference"}, errorPath="conference")
 */
class CompanyConferenceDetail
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="companyConferenceDetails")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $company;

    /**
     * @var Conference
     * @ORM\ManyToOne(targetEntity="Conference", inversedBy="companyConferenceDetails")
     * @ORM\JoinColumn(name="conference_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $conference;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Assert\NotBlank(message="field.not_blank")
     * @Assert\Length(max = 500)
     */
    private $nameRu;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Assert\NotBlank(message="field.not_blank")
     * @Assert\Length(max = 500)
     */
    private $nameEn;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Assert\Length(max = 500)
     */
    private $nameUk;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $activitiesUk;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $activitiesRu;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $activitiesEn;

    /**
     * @ORM\Column(type="string", length=1000)
     * @Assert\NotBlank(message="field.not_blank")
     * @Assert\Length(max = 1000)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=1000)
     * @Assert\NotBlank(message="field.not_blank")
     * @Assert\Length(max = 1000)
     */
    private $email;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Participant", mappedBy="companyConferenceDetail")
     */
    protected $participants;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param Company $company
     */
    public function setCompany(Company $company)
    {
        $this->company = $company;
    }

    /**
     * @return Conference
     */
    public function getConference()
    {
        return $this->conference;
    }

    /**
     * @param Conference $conference
     */
    public function setConference(Conference $conference)
    {
        $this->conference = $conference;
    }

    /**
     * @return mixed
     */
    public function getNameRu()
    {
        return $this->nameRu;
    }

    /**
     * @param mixed $nameRu
     */
    public function setNameRu($nameRu)
    {
        $this->nameRu = $nameRu;
    }

    /**
     * @return mixed
     */
    public function getNameEn()
    {
        return $this->nameEn;
    }

    /**
     * @param mixed $nameEn
     */
    public function setNameEn($nameEn)
    {
        $this->nameEn = $nameEn;
    }

    /**
     * @return mixed
     */
    public function getNameUk()
    {
        return $this->nameUk;
    }

    /**
     * @param mixed $nameUk
     */
    public function setNameUk($nameUk)
    {
        $this->nameUk = $nameUk;
    }

    /**
     * @return mixed
     */
    public function getActivitiesUk()
    {
        return $this->activitiesUk;
    }

    /**
     * @param mixed $activitiesUk
     */
    public function setActivitiesUk($activitiesUk)
    {
        $this->activitiesUk = $activitiesUk;
    }

    /**
     * @return mixed
     */
    public function getActivitiesRu()
    {
        return $this->activitiesRu;
    }

    /**
     * @param mixed $activitiesRu
     */
    public function setActivitiesRu($activitiesRu)
    {
        $this->activitiesRu = $activitiesRu;
    }

    /**
     * @return mixed
     */
    public function getActivitiesEn()
    {
        return $this->activitiesEn;
    }

    /**
     * @param mixed $activitiesEn
     */
    public function setActivitiesEn($activitiesEn)
    {
        $this->activitiesEn = $activitiesEn;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $language
     *
     * @return string
     */
    public function getName($language)
    {
        return $this->{"getName$language"}();
    }

    /**
     * @param string $language
     *
     * @return string
     */
    public function getActivities($language)
    {
        return $this->{"getActivities$language"}();
    }

    public function getFullName($language = 'ru')
    {
        $language = mb_strtolower($language);
        $fullName = $this->getName($language);
        $countryName = $this->company->getCountryName($language) ?: '';
        $crmId = $this->company->getCrmId() ?: '';
        if ($countryName || $crmId) {
            $fullName .= ' (' . ($countryName ? $countryName . ', ': '');
            $fullName .= $crmId . ')';
        }

        return $fullName;
    }

    /**
     * Add participant
     *
     * @param Participant $participant
     *
     * @return CompanyConferenceDetail
     */
    public function addParticipant(Participant $participant)
    {
        $this->participants[] = $participant;

        return $this;
    }

    /**
     * Remove participant
     *
     * @param Participant $participant
     */
    public function removeParticipant(Participant $participant)
    {
        $this->participants->removeElement($participant);
    }

    /**
     * Get participants
     *
     * @return \Doctrine\Common\Collections\Collection|Participant[]
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * Copy data from company.
     *
     * @param Company    $company
     * @param Conference $conference
     */
    public function setData(Company $company, Conference $conference)
    {
        $this->setConference($conference);
        $this->setCompany($company);

        $this->setActivitiesEn($this->getActivitiesEn() ?: $company->getActivitiesEn());
        $this->setActivitiesRu($this->getActivitiesRu() ?: $company->getActivitiesRu());
        $this->setActivitiesUk($this->getActivitiesUk() ?: $company->getActivitiesUk());

        $this->setNameEn($this->getNameEn() ?: $company->getNameEn());
        $this->setNameRu($this->getNameRu() ?: $company->getNameRu());
        $this->setNameUk($this->getNameUk() ?: $company->getNameUk());

        $this->setPhone($this->getPhone() ?: $company->getPhone());
        $this->setEmail($this->getEmail() ?: $company->getEmail());
    }

    public function getNameByLang($lang = 'ru')
    {
        switch (mb_strtolower($lang)) {
            case 'ru':
                return $this->nameRu;
            case 'en':
                return $this->nameEn;
            case 'uk':
                return $this->nameUk;
        }

        return '';
    }
}
