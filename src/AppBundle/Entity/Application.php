<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(
 *     name="application",
 *     indexes={
 *      @ORM\Index(name="IDX_hash", columns={"hash"}),
 *      @ORM\Index(name="IDX_is_started", columns={"is_started"})
 *  }
 * )
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Application
{
    use SoftDeleteableEntity;

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="applications")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=500)
     * @Assert\NotBlank(message="field.not_blank", groups={"LangRUStep-1"})
     * @Assert\Length(
     *      max = 500,
     *      maxMessage = "field.max_length",
     *      groups={"LangRUStep-1"}
     * )
     */
    private $nameRu;

    /**
     * @ORM\Column(type="string", length=500)
     * @Assert\NotBlank(message="field.not_blank", groups={"LangENStep-1"})
     * @Assert\Length(
     *      max = 500,
     *      maxMessage = "field.max_length",
     *      groups={"LangENStep-1"}
     * )
     */
    private $nameEn;

    /**
     * @ORM\Column(type="string", length=500)
     * @Assert\NotBlank(message="field.not_blank", groups={"LangUKStep-1"})
     * @Assert\Length(
     *      max = 500,
     *      maxMessage = "field.max_length",
     *      groups={"LangUKStep-1"}
     * )
     */
    private $nameUk;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $crmId;

    /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Person", mappedBy="application", cascade={"persist"})
     */
    private $persons;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $directorUk;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $directorRu;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $directorEn;

    /**
     * @ORM\Column(type="string", length=250, options={"default": ""})
     * @Assert\NotBlank(groups={"Step-2"}, message="field.not_blank")
     *
     * @Assert\Length(
     *      max = 250,
     *      maxMessage = "field.max_length",
     *      groups={"Step-2"}
     * )
     */
    private $director;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotBlank(message="field.not_blank", groups={"LangUKStep-1"})
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "field.max_length",
     *      groups={"LangUKStep-1"}
     * )
     */
    private $activitiesUk;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotBlank(message="field.not_blank", groups={"LangRUStep-1"})
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "field.max_length",
     *      groups={"LangRUStep-1"}
     * )
     */
    private $activitiesRu;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotBlank(message="field.not_blank", groups={"LangENStep-1"})
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "field.max_length",
     *      groups={"LangENStep-1"}
     * )
     */
    private $activitiesEn;

    /**
     * @ORM\Column(type="string", length=250)
     * @Assert\NotBlank(message="field.not_blank", groups={"Step-1"})
     * @Assert\Length(
     *      max = 250,
     *      maxMessage = "field.max_length",
     *      groups={"Step-1"}
     * )
     */
    private $contact;

    /**
     * @ORM\Column(type="string", length=250)
     * @Assert\NotBlank(message="field.not_blank", groups={"Step-1"})
     * @Assert\Length(
     *      max = 250,
     *      maxMessage = "field.max_length",
     *      groups={"Step-1"}
     * )
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=250)
     * @Assert\NotBlank(message="field.not_blank", groups={"Step-1"})
     * @Assert\Email(message="field.required_contain_email", groups={"Step-1"})
     * @Assert\Length(
     *      max = 250,
     *      maxMessage = "field.max_length",
     *      groups={"Step-1"}
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
     * @Assert\NotBlank(message="field.not_blank", groups={"Step-2"})
     * @Assert\Length(
     *      max = 250,
     *      maxMessage = "field.max_length", groups={"Step-2"}
     * )
     */
    private $legalCompanyName;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     * @Assert\NotBlank(message="field.not_blank", groups={"Step-1"})
     * @Assert\Length(
     *      max = 2,
     *      maxMessage = "field.max_length", groups={"Step-1"}
     * )
     */
    private $country;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotBlank(message="field.not_blank", groups={"Step-2"})
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "field.max_length",
     *      groups={"Step-2"}
     *
     * )
     */
    private $legalAddress;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotBlank(message="field.not_blank", groups={"Step-2"})
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "field.max_length",
     *      groups={"Step-2"}
     *
     * )
     */
    private $mailAddress;

    /**
     * @ORM\Column(type="string", length=250)
     * @Assert\NotBlank(message="field.not_blank", groups={"Step-2"})
     * @Assert\Length(
     *      max = 250,
     *      maxMessage = "field.max_length",
     *      groups={"Step-2"}
     * )
     */
    private $legalId;

    /**
     * @ORM\Column(type="string", length=250)
     * @Assert\Length(
     *      max = 250,
     *      maxMessage = "field.max_length",
     *      groups={"Step-2"}
     * )
     */
    private $taxId;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var ApplicationParticipant[]
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\ApplicationParticipant", mappedBy="application", cascade={"persist"})
     * @Assert\Count(min="1", minMessage="field.participant_required", groups={"Step-3"})
     * @Assert\Valid()
     */
    private $applicationParticipants;

    /**
     * @ORM\Column(type="string", length=250, nullable=false, options={"default": ""})
     */
    private $vatLicence;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $companyCrmId;

    /**
     * @ORM\Column(type="string", length=250, nullable=false, options={"default": ""})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=2, nullable=false, options={"default": ""})
     * @Assert\Length(
     *      max = 2,
     *      maxMessage = "field.max_length"
     * )
     */
    private $language;

    /**
     * @ORM\Column(type="string", length=250, nullable=false, options={"default": ""})
     */
    private $languages;

    /**
     * @ORM\Column(type="string", length=32, nullable=false, options={"default": ""}, unique=true)
     */
    private $hash;

    /**
     * @ORM\Column(type="boolean", name="completed", options={"default":0})
     */
    private $completed;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isProcessed;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isStarted;

    /**
     * @var Conference
     * @ORM\ManyToOne(targetEntity="Conference", inversedBy="applications")
     * @ORM\JoinColumn(name="conference_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotBlank(message="field.not_blank")
     */
    private $conference;

    /**
     * @var ArrayCollection|ApplicationParticipationType[]
     *
     * @ORM\OneToMany(targetEntity="ApplicationParticipationType", mappedBy="application", cascade={"persist"}, orphanRemoval=true)
     */
    private $applicationParticipationTypes;

    /**
     * @var Currency
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Currency")
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    private $currency;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->persons = new ArrayCollection();
        $this->applicationParticipants = new ArrayCollection();
        $this->applicationParticipationTypes = new ArrayCollection();
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
        $this->username = '';
        $this->language = '';
        $this->languages = '';
        $this->hash = '';
        $this->completed = false;
        $this->isProcessed = false;
        $this->isStarted = false;
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
     * @return Application
     */
    public function setNameRu($nameRu)
    {
        $this->nameRu = $nameRu;

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
     * @return Application
     */
    public function setNameEn($nameEn)
    {
        $this->nameEn = $nameEn;

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
     * @return Application
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

    /**
     * Get names
     *
     * @return string
     */
    public function getAllNames()
    {
        return implode('/', array_filter([$this->nameRu, $this->nameEn, $this->nameUk]));
    }

    /**
     * Returns first not empty company name.
     *
     * @return string
     */
    public function getCompanyName()
    {
        $company = $this->getCompany();
        if (!$company) {
            return '-';
        }

        $names = array_filter([$company->getNameRu(), $company->getNameUk(), $company->getNameEn()]);

        return reset($names) ?: '-';
    }


    /**
     * Set crmId
     *
     * @param integer $crmId
     *
     * @return Application
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
     * Set directorUk
     *
     * @param string $directorUk
     *
     * @return Application
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
     * @return Application
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
     * @return Application
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
     * Set activitiesUk
     *
     * @param string $activitiesUk
     *
     * @return Application
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
     * @return Application
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
     * @return Application
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
     * @return mixed
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * @param mixed $director
     */
    public function setDirector($director)
    {
        $this->director = (string)$director;
    }

    /**
     * Set contact
     *
     * @param string $contact
     *
     * @return Application
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
     * @return Application
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
     * @return Application
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
     * @return Application
     */
    public function setAddressEn($addressEn)
    {
        $this->addressEn = $addressEn;

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
     * @return Application
     */
    public function setAddressUk($addressUk)
    {
        $this->addressUk = $addressUk;

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
     * @return Application
     */
    public function setAddressRu($addressRu)
    {
        $this->addressRu = $addressRu;

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
     * @return Application
     */
    public function setLegalCompanyName($legalCompanyName)
    {
        $this->legalCompanyName = $legalCompanyName;

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
     * @return Application
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
     * Set legalAddress
     *
     * @param string $legalAddress
     *
     * @return Application
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
     * @return Application
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
     * @return Application
     */
    public function setLegalId($legalId)
    {
        $this->legalId = $legalId;

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
     * @return Application
     */
    public function setTaxId($taxId)
    {
        $this->taxId = $taxId ?: '';

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Application
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set company
     *
     * @param \AppBundle\Entity\Company $company
     *
     * @return Application
     */
    public function setCompany(\AppBundle\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \AppBundle\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Add person
     *
     * @param Person $person
     *
     * @return Application
     */
    public function addPerson(Person $person)
    {
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersons()
    {
        return $this->persons;
    }

    /**
     * Add applicationParticipant
     *
     * @param ApplicationParticipant $applicationParticipant
     *
     * @return Application
     */
    public function addApplicationParticipant(ApplicationParticipant $applicationParticipant)
    {
        $applicationParticipant->setApplication($this);
        $this->applicationParticipants[] = $applicationParticipant;

        return $this;
    }

    /**
     * Remove applicationParticipant
     *
     * @param ApplicationParticipant $applicationParticipant
     */
    public function removeApplicationParticipant(ApplicationParticipant $applicationParticipant)
    {
        $this->applicationParticipants->removeElement($applicationParticipant);
    }

    /**
     * Get applicationParticipants
     *
     * @return \Doctrine\Common\Collections\Collection|ApplicationParticipant[]
     */
    public function getApplicationParticipants()
    {
        return $this->applicationParticipants;
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

    /**
     * @return integer
     */
    public function getCompanyCrmId()
    {
        return $this->companyCrmId;
    }

    /**
     * @param integer $companyCrmId
     *
     * @return $this
     */
    public function setCompanyCrmId($companyCrmId)
    {
        $this->companyCrmId = $companyCrmId;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     *
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return string
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * @param integer $limit
     *
     * @return array
     */
    public function getLanguagesArray($limit = 2)
    {
        return explode(',', mb_strtoupper($this->languages), $limit);
    }

    /**
     * @param string $languages
     *
     * @return $this
     */
    public function setLanguages($languages)
    {
        $this->languages = $languages;

        return $this;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     *
     * @return $this
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    public function initializeHash()
    {
        $this->hash = bin2hex(random_bytes(16));
    }

    /**
     * @param Company $company
     */
    public function populateFromCompany(Company $company)
    {
        $this->setCompany($company);

        $this->setEmail($company->getEmail());
        $this->setMailAddress($company->getMailAddress());

        $this->setActivitiesEn($company->getActivitiesEn());
        $this->setActivitiesRu($company->getActivitiesRu());
        $this->setActivitiesUk($company->getActivitiesUk());

        $this->setAddressRu($company->getAddressRu());
        $this->setAddressEn($company->getAddressEn());
        $this->setAddressUk($company->getAddressUk());

        $this->setContact($company->getContact());
        $this->setCountry($company->getCountry());
        $this->setCrmId($company->getCrmId());
        $this->setTaxId($company->getTaxId());
        $this->setPhone($company->getPhone());

        $this->setDirectorEn($company->getDirectorEn());
        $this->setDirectorUk($company->getDirectorUk());
        $this->setDirectorRu($company->getDirectorRu());

        $this->setNameEn($company->getNameEn());
        $this->setNameRu($company->getNameRu());
        $this->setNameUk($company->getNameUk());

        $this->setLegalAddress($company->getLegalAddress());
        $this->setLegalId($company->getLegalId());
        $this->setLegalCompanyName($company->getLegalCompanyName());

        $this->setVatLicence($company->getVatLicence());
    }

    public function getCompleted()
    {
        return $this->completed;
    }

    public function setCompleted($completed)
    {
        $this->completed = $completed;
    }

    /**
     * Get isProcessed
     *
     * @return boolean
     */
    public function getIsProcessed()
    {
        return $this->isProcessed;
    }

    /**
     * Set isProcessed
     *
     * @param boolean $isProcessed
     *
     * @return $this
     */
    public function setIsProcessed($isProcessed)
    {
        $this->isProcessed = $isProcessed;

        return $this;
    }

    public function getIsStarted()
    {
        return $this->isStarted;
    }

    public function setIsStarted($isStarted)
    {
        $this->isStarted = $isStarted;
    }

    /**
     * Set conference
     *
     * @param Conference $conference
     *
     * @return $this
     */
    public function setConference(Conference $conference)
    {
        $this->conference = $conference;

        return $this;
    }

    /**
     * Get conference
     *
     * @return Conference
     */
    public function getConference()
    {
        return $this->conference;
    }

    public function getStatus()
    {
        return $this->isProcessed ? 'Обработана' : 'Не обработана';
    }

    public function hasPersonInParticipants(Person $person)
    {
        return $this
            ->applicationParticipants
            ->exists(function ($index, ApplicationParticipant $applicationParticipant) use ($person) {
                return $applicationParticipant->getPerson() === $person;
            });
    }

    /**
     * @return ApplicationParticipationType[]|ArrayCollection
     */
    public function getApplicationParticipationTypes()
    {
        return $this->applicationParticipationTypes;
    }

    /**
     * @param ApplicationParticipationType $applicationParticipationType
     */
    public function addApplicationParticipationType(ApplicationParticipationType $applicationParticipationType)
    {
        $applicationParticipationType->setApplication($this);
        $this->applicationParticipationTypes->add($applicationParticipationType);
    }

    /**
     * @param ApplicationParticipationType $applicationParticipationType
     */
    public function removeApplicationParticipationType(ApplicationParticipationType $applicationParticipationType)
    {
        $this->applicationParticipationTypes->removeElement($applicationParticipationType);
    }

    /**
     * @return ParticipationType[]
     */
    public function getParticipationTypes()
    {
        $participationTypes = [];
        foreach ($this->getApplicationParticipationTypes() as $applicationParticipationType) {
            $participationTypes[] = $applicationParticipationType->getParticipationType();
        }

        return $participationTypes;
    }

    /**
     * @return Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     */
    public function setCurrency(Currency $currency)
    {
        $this->currency = $currency;
    }

    /**
     * @param ParticipationType $participationType
     */
    public function addParticipationType(ParticipationType $participationType)
    {
        $applicationParticipationType = new ApplicationParticipationType();
        $applicationParticipationType->setParticipationType($participationType);
        $this->addApplicationParticipationType($applicationParticipationType);
    }

    /**
     * @param ParticipationType $participationType
     */
    public function removeParticipationType(ParticipationType $participationType)
    {
        foreach ($this->getApplicationParticipationTypes() as $applicationParticipationType) {
            if ($applicationParticipationType->getParticipationType() === $participationType) {
                $this->removeApplicationParticipationType($applicationParticipationType);
            }
        }
    }

    /**
     * @return ApplicationParticipationType[]
     */
    public function getAdditionalApplicationParticipationTypes()
    {
        $additionalTypes = [];
        foreach ($this->getApplicationParticipationTypes() as $applicationParticipationType) {
            if ($applicationParticipationType->getParticipationType()->getIsAdditional()) {
                $additionalTypes[] = $applicationParticipationType;
            }
        }

        return $additionalTypes;
    }
}
