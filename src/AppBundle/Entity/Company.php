<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="companies")
 * @ORM\Entity
 */
class Company
{

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Assert\NotBlank(message="field.not_blank", groups={"Default", "ApplicationCompany", "light_participant"})
     * @Assert\Length(
     *      max = 500,
     *      maxMessage = "field.max_length",
     *      groups={"Default", "ApplicationCompany"}
     * )
     */
    private $nameRu;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Assert\NotBlank(message="field.not_blank", groups={"Default", "ApplicationCompany", "light_participant"})
     * @Assert\Length(
     *      max = 500,
     *      maxMessage = "field.max_length",
     *      groups={"Default", "ApplicationCompany"}
     * )
     */
    private $nameEn;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Assert\Length(
     *      max = 500,
     *      maxMessage = "field.max_length",
     *      groups={"Default", "ApplicationCompany"}
     * )
     */
    private $nameUk;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $crmId;

    /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Person", mappedBy="company", cascade={"persist"})
     * @var Collection|Person[]
     */
    private $persons;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     * @Assert\Length(
     *      max = 250,
     *      maxMessage = "field.max_length",
     *      groups={"Default", "ApplicationCompany"}
     * )
     */
    private $directorUk;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     * @Assert\Length(
     *      max = 250,
     *      maxMessage = "field.max_length",
     *      groups={"Default", "ApplicationCompany"}
     * )
     */
    private $directorRu;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     * @Assert\Length(
     *      max = 250,
     *      maxMessage = "field.max_length",
     *      groups={"Default", "ApplicationCompany"}
     * )
     */
    private $directorEn;

    /**
     * @ORM\Column(type="string", length=250, options={"default": ""})
     * @Assert\NotBlank(message="field.not_blank", groups={"ApplicationCompany"})
     * @Assert\Length(
     *      max = 250,
     *      maxMessage = "field.max_length",
     *      groups={"Default", "ApplicationCompany"}
     * )
     */
    private $director;

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
     * @ORM\Column(type="string", length=250)
     * @Assert\NotBlank(message="field.not_blank", groups={"ApplicationCompany"})
     * @Assert\Length(
     *      max = 250,
     *      maxMessage = "field.max_length",
     *      groups={"Default", "ApplicationCompany"}
     * )
     */
    private $contact;

    /**
     * @ORM\Column(type="string", length=1000)
     * @Assert\NotBlank(message="field.not_blank", groups={"ApplicationCompany"})
     * @Assert\Length(
     *      max = 1000,
     *      maxMessage = "field.max_length",
     *      groups={"Default", "ApplicationCompany"}
     * )
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=1000)
     * @Assert\NotBlank(message="field.not_blank", groups={"ApplicationCompany"})
     * @Assert\Length(
     *      max = 1000,
     *      maxMessage = "field.max_length",
     *      groups={"Default", "ApplicationCompany"}
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $addressEn;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $addressUk;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $addressRu;

    /**
     * @ORM\Column(type="string", length=250)
     * @Assert\NotBlank(message="field.not_blank", groups={"ApplicationCompany"})
     * @Assert\Length(
     *      max = 250,
     *      maxMessage = "field.max_length",
     *      groups={"Default", "ApplicationCompany"}
     * )
     */
    private $legalCompanyName;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     * @Assert\Length(
     *      max = 2,
     *      maxMessage = "field.max_length",
     *      groups={"Default", "ApplicationCompany", "light_participant"}
     * )
     */
    private $country;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $legalAddress;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $mailAddress;

    /**
     * @ORM\Column(type="string", length=250)
     * @Assert\NotBlank(message="field.not_blank", groups={"ApplicationCompany"})
     * @Assert\Length(
     *      max = 250,
     *      maxMessage = "field.max_length",
     *      groups={"Default", "ApplicationCompany"}
     * )
     */
    private $legalId;

    /**
     * @ORM\Column(type="string", length=250)
     * @Assert\Length(
     *      max = 250,
     *      maxMessage = "field.max_length",
     *      groups={"Default", "ApplicationCompany"}
     * )
     */
    private $taxId;

    /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Application", mappedBy="company")
     */
    private $applications;

    /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\CompanyUser", mappedBy="company")
     */
    private $users;

    /**
     * @var ArrayCollection|CompanyConferenceDetail[]
     * @ORM\OneToMany(targetEntity="CompanyConferenceDetail", mappedBy="company")
     */
    private $companyConferenceDetails;

    /**
     * @ORM\Column(type="string", length=250, nullable=false, options={"default": ""})
     */
    private $vatLicence;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->persons = new ArrayCollection();
        $this->nameUk = '';
        $this->nameEn = '';
        $this->nameRu = '';
        $this->directorUk = '';
        $this->directorEn = '';
        $this->directorRu = '';
        $this->director = '';
        $this->contact = '';
        $this->phone = '';
        $this->email = '';
        $this->legalCompanyName = '';
        $this->legalId = '';
        $this->taxId = '';
        $this->vatLicence = '';
    }

    public function __toString()
    {
        return $this->nameRu;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nameRu
     *
     * @param string $nameRu
     *
     * @return Company
     */
    public function setNameRu($nameRu)
    {
        $this->nameRu = (string)$nameRu;

        return $this;
    }

    /**
     * Get nameRu
     *
     * @return string
     */
    public function getNameRu()
    {
        return $this->nameRu;
    }

    /**
     * Set nameEn
     *
     * @param string $nameEn
     *
     * @return Company
     */
    public function setNameEn($nameEn)
    {
        $this->nameEn = (string)$nameEn;

        return $this;
    }

    /**
     * Get nameEn
     *
     * @return string
     */
    public function getNameEn()
    {
        return $this->nameEn;
    }

    /**
     * Set nameUk
     *
     * @param string $nameUk
     *
     * @return Company
     */
    public function setNameUk($nameUk)
    {
        $this->nameUk = $nameUk;

        return $this;
    }

    /**
     * Get nameUk
     *
     * @return string
     */
    public function getNameUk()
    {
        return $this->nameUk;
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

    public function getFullName($language = 'ru')
    {
        $language = mb_strtolower($language);
        $fullName = $this->getName($language);
        $countryName = $this->getCountryName($language) ?: '';
        $crmId = $this->getCrmId() ?: '';
        if ($countryName || $crmId) {
            $fullName .= ' (' . ($countryName ? $countryName . ', ': '');
            $fullName .= $crmId . ')';
        }

        return $fullName;
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

    /**
     * Set crmId
     *
     * @param integer $crmId
     *
     * @return Company
     */
    public function setCrmId($crmId)
    {
        $this->crmId = $crmId;

        return $this;
    }

    /**
     * Get crmId
     *
     * @return integer
     */
    public function getCrmId()
    {
        return $this->crmId;
    }

    /**
     * Add person
     *
     * @param Person $person
     *
     * @return Company
     */
    public function addPerson(Person $person)
    {
        $person->setCompany($this);
        $this->persons[] = $person;

        return $this;
    }

    /**
     * Remove person
     *
     * @param Person $person
     */
    public function removePerson(Person $person)
    {
        $this->persons->removeElement($person);
    }

    /**
     * Get persons
     *
     * @return Collection|Person[]
     */
    public function getPersons()
    {
        return $this->persons;
    }

    /**
     * Set directorUk
     *
     * @param string $directorUk
     *
     * @return Company
     */
    public function setDirectorUk($directorUk)
    {
        $this->directorUk = (string)$directorUk;

        return $this;
    }

    /**
     * Get directorUk
     *
     * @return string
     */
    public function getDirectorUk()
    {
        return $this->directorUk;
    }

    /**
     * Set directorRu
     *
     * @param string $directorRu
     *
     * @return Company
     */
    public function setDirectorRu($directorRu)
    {
        $this->directorRu = (string)$directorRu;

        return $this;
    }

    /**
     * Get directorRu
     *
     * @return string
     */
    public function getDirectorRu()
    {
        return $this->directorRu;
    }

    /**
     * Set directorEn
     *
     * @param string $directorEn
     *
     * @return Company
     */
    public function setDirectorEn($directorEn)
    {
        $this->directorEn = (string)$directorEn;

        return $this;
    }

    /**
     * Get directorEn
     *
     * @return string
     */
    public function getDirectorEn()
    {
        return $this->directorEn;
    }

    /**
     * @return mixed
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * @param string $director
     */
    public function setDirector($director)
    {
        $this->director = (string)$director;
    }

    /**
     * Set activitiesUk
     *
     * @param string $activitiesUk
     *
     * @return Company
     */
    public function setActivitiesUk($activitiesUk)
    {
        $this->activitiesUk = (string)$activitiesUk;

        return $this;
    }

    /**
     * Get activitiesUk
     *
     * @return string
     */
    public function getActivitiesUk()
    {
        return $this->activitiesUk;
    }

    /**
     * Set activitiesRu
     *
     * @param string $activitiesRu
     *
     * @return Company
     */
    public function setActivitiesRu($activitiesRu)
    {
        $this->activitiesRu = (string)$activitiesRu;

        return $this;
    }

    /**
     * Get activitiesRu
     *
     * @return string
     */
    public function getActivitiesRu()
    {
        return $this->activitiesRu;
    }

    /**
     * Set activitiesEn
     *
     * @param string $activitiesEn
     *
     * @return Company
     */
    public function setActivitiesEn($activitiesEn)
    {
        $this->activitiesEn = (string)$activitiesEn;

        return $this;
    }

    /**
     * Get activitiesEn
     *
     * @return string
     */
    public function getActivitiesEn()
    {
        return $this->activitiesEn;
    }

    /**
     * Set contact
     *
     * @param string $contact
     *
     * @return Company
     */
    public function setContact($contact)
    {
        $this->contact = (string)$contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Company
     */
    public function setPhone($phone)
    {
        $this->phone = (string)$phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Company
     */
    public function setEmail($email)
    {
        $this->email = (string)$email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set addressEn
     *
     * @param string $addressEn
     *
     * @return Company
     */
    public function setAddressEn($addressEn)
    {
        $this->addressEn = (string)$addressEn;

        return $this;
    }

    /**
     * Get addressEn
     *
     * @return string
     */
    public function getAddressEn()
    {
        return $this->addressEn;
    }

    /**
     * Set addressUk
     *
     * @param string $addressUk
     *
     * @return Company
     */
    public function setAddressUk($addressUk)
    {
        $this->addressUk = (string)$addressUk;

        return $this;
    }

    /**
     * Get addressUk
     *
     * @return string
     */
    public function getAddressUk()
    {
        return $this->addressUk;
    }

    /**
     * Set addressRu
     *
     * @param string $addressRu
     *
     * @return Company
     */
    public function setAddressRu($addressRu)
    {
        $this->addressRu = (string)$addressRu;

        return $this;
    }

    /**
     * Get addressRu
     *
     * @return string
     */
    public function getAddressRu()
    {
        return $this->addressRu;
    }

    /**
     * Set legalCompanyName
     *
     * @param string $legalCompanyName
     *
     * @return Company
     */
    public function setLegalCompanyName($legalCompanyName)
    {
        $this->legalCompanyName = (string)$legalCompanyName;

        return $this;
    }

    /**
     * Get legalCompanyName
     *
     * @return string
     */
    public function getLegalCompanyName()
    {
        return $this->legalCompanyName;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Company
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Returns country name for a given locale.
     *
     * @return null|string
     */
    public function getCountryName($locale = null)
    {
        return Intl::getRegionBundle()->getCountryName($this->country, $locale);
    }

    /**
     * Returns country name for a given locale.
     *
     * @return null|string
     */
    public function getCountryNameByLanguages($languages)
    {
        if (in_array('en', $languages)) {
            return $this->getCountryName('en');
        }

        reset($languages);
        return $this->getCountryName(current($languages));
    }

    /**
     * Set legalAddress
     *
     * @param string $legalAddress
     *
     * @return Company
     */
    public function setLegalAddress($legalAddress)
    {
        $this->legalAddress = $legalAddress;

        return $this;
    }

    /**
     * Get legalAddress
     *
     * @return string
     */
    public function getLegalAddress()
    {
        return $this->legalAddress;
    }

    /**
     * Set mailAddress
     *
     * @param string $mailAddress
     *
     * @return Company
     */
    public function setMailAddress($mailAddress)
    {
        $this->mailAddress = $mailAddress;

        return $this;
    }

    /**
     * Get mailAddress
     *
     * @return string
     */
    public function getMailAddress()
    {
        return $this->mailAddress;
    }

    /**
     * Set legalId
     *
     * @param string $legalId
     *
     * @return Company
     */
    public function setLegalId($legalId)
    {
        $this->legalId = (string)$legalId;

        return $this;
    }

    /**
     * Get legalId
     *
     * @return string
     */
    public function getLegalId()
    {
        return $this->legalId;
    }

    /**
     * Set taxId
     *
     * @param string $taxId
     *
     * @return Company
     */
    public function setTaxId($taxId)
    {
        $this->taxId = (string)$taxId ?: '';

        return $this;
    }

    /**
     * Get taxId
     *
     * @return string
     */
    public function getTaxId()
    {
        return $this->taxId;
    }

    /**
     * Add application
     *
     * @param Application $application
     *
     * @return Company
     */
    public function addApplication(Application $application)
    {
        $this->applications[] = $application;

        return $this;
    }

    /**
     * Remove application
     *
     * @param Application $application
     */
    public function removeApplication(Application $application)
    {
        $this->applications->removeElement($application);
    }

    /**
     * Get application
     *
     * @return Collection|Application[]
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Add user
     *
     * @param CompanyUser $companyUser
     *
     * @return Company
     */
    public function addUser(CompanyUser $companyUser)
    {
        $this->users[] = $companyUser;

        return $this;
    }

    /**
     * Remove user
     *
     * @param CompanyUser $companyUser
     */
    public function removeUser(CompanyUser $companyUser)
    {
        $this->users->removeElement($companyUser);
    }

    /**
     * @return Collection|CompanyUser[]
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @return CompanyConferenceDetail[]|ArrayCollection
     */
    public function getCompanyConferenceDetails()
    {
        return $this->companyConferenceDetails;
    }

    /**
     * @return string
     */
    public function getVatLicence()
    {
        return $this->vatLicence;
    }

    /**
     * @param string $vatLicence
     *
     * @return $this
     */
    public function setVatLicence($vatLicence)
    {
        $this->vatLicence = (string)$vatLicence;

        return $this;
    }
}
