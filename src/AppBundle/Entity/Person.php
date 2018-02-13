<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User;
use AppBundle\Validator\Constraints as UserAssert;

/**
 * @ORM\Table(name="persons")
 * @ORM\Entity
 * @ORM\AttributeOverrides({
 *     @ORM\AttributeOverride(name="email",
 *          column=@ORM\Column(
 *              name     = "email",
 *              type     = "string",
 *              length   = 255,
 *              nullable = true
 *          )
 *      ),
 *     @ORM\AttributeOverride(name="emailCanonical",
 *          column=@ORM\Column(
 *              nullable = true
 *          )
 *      ),
 *     @ORM\AttributeOverride(name="username",
 *          column=@ORM\Column(
 *              nullable = true
 *          )
 *      ),
 *     @ORM\AttributeOverride(name="usernameCanonical",
 *          column=@ORM\Column(
 *              nullable = true
 *          )
 *      ),
 *     @ORM\AttributeOverride(name="password",
 *          column=@ORM\Column(
 *              nullable = true
 *          )
 *      ),
 * })
 */
class Person extends User
{

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\NotBlank(groups={"Default", "ApplicationParticipants"}, message="field.not_blank")
     * @Assert\Email(groups={"Default", "ApplicationParticipants", "light_participant"})
     */
    protected $email;

    /**
     * @ORM\Column(length=255, nullable=true, nullable=true)
     * @Assert\Email(message="field.required_contain_email", groups={"change_email"})
     * @UserAssert\IsUniqueEmail(groups={"change_profile"})
     */
    private $newEmail;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $newEmailConfirmation;

    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="persons")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"Default", "ApplicationParticipants", "change_profile", "light_participant"}, message="field.not_blank")
     */
    private $firstNameRu;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"Default", "ApplicationParticipants", "change_profile", "light_participant"}, message="field.not_blank")
     */
    private $lastNameRu;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"Default", "ApplicationParticipants", "change_profile", "light_participant"}, message="field.not_blank")
     */
    private $firstNameEn;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"Default", "ApplicationParticipants", "change_profile", "light_participant"}, message="field.not_blank")
     */
    private $lastNameEn;

    /**
     * @ORM\Column(type="string", length=255, options={"default": ""})
     */
    private $firstNameUk;

    /**
     * @ORM\Column(type="string", length=255, options={"default": ""})
     */
    private $lastNameUk;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"Default", "ApplicationParticipants", "change_profile"}, message="field.not_blank")
     */
    private $phone;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    private $crmId;

    /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Participant", mappedBy="person")
     */
    private $participants;

    /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\ApplicationParticipant", mappedBy="person")
     */
    private $applicationParticipants;

    /**
     * @var Application
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Application", inversedBy="persons")
     * @ORM\JoinColumn(name="application_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $application;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Expression(
     *     "this.checkPosition() == true",
     *     groups={"Default", "ApplicationParticipants"}
     * )
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "field.max_length",
     *      groups={"Default", "ApplicationParticipants"}
     * )
     */
    private $positionRu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Expression(
     *     "this.checkPosition() == true",
     *     groups={"Default", "ApplicationParticipants"}
     * )
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "field.max_length",
     *     groups={"Default", "ApplicationParticipants"}
     * )
     */
    private $positionEn;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Expression(
     *     "this.checkPosition() == true",
     *     groups={"Default", "ApplicationParticipants"}
     * )
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "field.max_length",
     *      groups={"Default", "ApplicationParticipants"}
     * )
     */
    private $positionUk;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Speech", mappedBy="speaker")
     */
    protected $speeches;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $showEmail;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $showPhone;

    /**
     * @var string
     * @ORM\Column(type="string", length=2, nullable=true, options={"fixed" = true})
     */
    private $locale;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->participants = new ArrayCollection();
        $this->applicationParticipants = new ArrayCollection();
        $this->email = '';
        $this->phone = '';
        $this->firstNameRu = '';
        $this->lastNameRu = '';
        $this->firstNameEn = '';
        $this->lastNameEn = '';
        $this->firstNameUk = '';
        $this->lastNameUk = '';
        $this->crmId = '';
        $this->showEmail = false;
        $this->showPhone = false;
        $this->password = '';
    }

    /**
     * @return bool
     */
    public function checkPosition()
    {
        return !empty($this->positionEn) || !empty($this->positionRu) || !empty($this->positionUk);
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
     * Set email
     *
     * @param string $email
     *
     * @return Person
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
     * Set phone
     *
     * @param string $phone
     *
     * @return Person
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

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
     * Set crmId
     *
     * @param string $crmId
     *
     * @return Person
     */
    public function setCrmId($crmId)
    {
        $this->crmId = $crmId;

        return $this;
    }

    /**
     * Get crmId
     *
     * @return string
     */
    public function getCrmId()
    {
        return $this->crmId;
    }

    /**
     * Set company
     *
     * @param Company $company
     *
     * @return Person
     */
    public function setCompany(Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Add participant
     *
     * @param \AppBundle\Entity\Participant $participant
     *
     * @return Person
     */
    public function addParticipant(\AppBundle\Entity\Participant $participant)
    {
        $this->participants[] = $participant;

        return $this;
    }

    /**
     * Remove participant
     *
     * @param \AppBundle\Entity\Participant $participant
     */
    public function removeParticipant(\AppBundle\Entity\Participant $participant)
    {
        $this->participants->removeElement($participant);
    }

    /**
     * Get participants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * Set firstNameRu
     *
     * @param string $firstNameRu
     *
     * @return Person
     */
    public function setFirstNameRu($firstNameRu)
    {
        $this->firstNameRu = $firstNameRu;

        return $this;
    }

    /**
     * Get firstNameRu
     *
     * @return string
     */
    public function getFirstNameRu()
    {
        return $this->firstNameRu;
    }

    /**
     * Set lastNameRu
     *
     * @param string $lastNameRu
     *
     * @return Person
     */
    public function setLastNameRu($lastNameRu)
    {
        $this->lastNameRu = $lastNameRu;

        return $this;
    }

    /**
     * Get lastNameRu
     *
     * @return string
     */
    public function getLastNameRu()
    {
        return $this->lastNameRu;
    }

    /**
     * @return string
     */
    public function getNameRu()
    {
        return sprintf("%s %s", $this->firstNameRu, $this->lastNameRu);
    }

    public function getNameByLang($lang)
    {
        switch (mb_strtolower($lang)) {
            case 'ru':
                return sprintf('%s %s', $this->firstNameRu, $this->lastNameRu);
            case 'en':
                return sprintf('%s %s', $this->firstNameEn, $this->lastNameEn);
            case 'uk':
                return sprintf('%s %s', $this->firstNameUk, $this->lastNameUk);
        }

        return '';
    }

    public function getTitle($lang = 'ru')
    {
        $position = $this->{"getPosition$lang"}();
        $fullName = $this->{"getFirstName$lang"}().' '.$this->{"getLastName$lang"}();

        if (!$position) {
            return $fullName;
        }

        return $fullName . ', '.$position;
    }

    public function getFullName($prefferedLocale = null)
    {
        $languages = ['ru', 'uk', 'en'];
        if ($prefferedLocale) {
            $languages = array_unique(array_merge([$prefferedLocale], $languages));
        }
        foreach ($languages as $language) {
            $firstName = $this->{"getFirstName$language"}();
            $lastName = $this->{"getLastName$language"}();

            if ($firstName && $lastName) {
                return $firstName.' '.$lastName;
            }
        }

        return $this->getNameRu();
    }

    /**
     * Set firstNameEn
     *
     * @param string $firstNameEn
     *
     * @return Person
     */
    public function setFirstNameEn($firstNameEn)
    {
        $this->firstNameEn = $firstNameEn;

        return $this;
    }

    /**
     * Get firstNameEn
     *
     * @return string
     */
    public function getFirstNameEn()
    {
        return $this->firstNameEn;
    }

    /**
     * Set lastNameEn
     *
     * @param string $lastNameEn
     *
     * @return Person
     */
    public function setLastNameEn($lastNameEn)
    {
        $this->lastNameEn = $lastNameEn;

        return $this;
    }

    /**
     * Get lastNameEn
     *
     * @return string
     */
    public function getLastNameEn()
    {
        return $this->lastNameEn;
    }

    /**
     * @return string
     */
    public function getNameEn()
    {
        return sprintf("%s %s", $this->firstNameEn, $this->lastNameEn);
    }

    /**
     * Set firstNameUk
     *
     * @param string $firstNameUk
     *
     * @return Person
     */
    public function setFirstNameUk($firstNameUk)
    {
        $this->firstNameUk = (string)$firstNameUk;

        return $this;
    }

    /**
     * Get firstNameUk
     *
     * @return string
     */
    public function getFirstNameUk()
    {
        return $this->firstNameUk;
    }

    /**
     * Set lastNameUk
     *
     * @param string $lastNameUk
     *
     * @return Person
     */
    public function setLastNameUk($lastNameUk)
    {
        $this->lastNameUk = (string)$lastNameUk;

        return $this;
    }

    /**
     * Get lastNameUk
     *
     * @return string
     */
    public function getLastNameUk()
    {
        return $this->lastNameUk;
    }

    /**
     * @return string
     */
    public function getNameUk()
    {
        return sprintf("%s %s", $this->firstNameUk, $this->lastNameUk);
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
     * Add applicationParticipant
     *
     * @param ApplicationParticipant $applicationParticipant
     *
     * @return Person
     */
    public function addApplicationParticipant(ApplicationParticipant $applicationParticipant)
    {
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApplicationParticipants()
    {
        return $this->applicationParticipants;
    }

    /**
     * Set application
     *
     * @param Application $application
     *
     * @return Person
     */
    public function setApplication(Application $application = null)
    {
        $this->application = $application;

        return $this;
    }

    /**f
     * Get application
     *
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    public function getPositionRu()
    {
        return $this->positionRu;
    }

    public function setPositionRu($positionRu)
    {
        $this->positionRu = $positionRu;
    }

    public function getPositionEn()
    {
        return $this->positionEn;
    }

    public function setPositionEn($positionEn)
    {
        $this->positionEn = $positionEn;
    }

    public function getPositionUk()
    {
        return $this->positionUk;
    }

    public function setPositionUk($positionUk)
    {
        $this->positionUk = $positionUk;
    }

    public function getPosition($prefferedLocale = null)
    {
        $languages = ['ru', 'uk', 'en'];
        if ($prefferedLocale) {
            $languages = array_unique(array_merge([$prefferedLocale], $languages));
        }
        foreach ($languages as $language) {
            $position = $this->{"getPosition$language"}();
            if ($position) {
                return $position;
            }
        }

        return '';
    }

    /**
     * @return string
     */
    public function getNewEmail()
    {
        return $this->newEmail;
    }

    /**
     * @param string $newEmail
     */
    public function setNewEmail($newEmail)
    {
        $this->newEmail = $newEmail;
    }

    /**
     * @return mixed
     */
    public function getNewEmailConfirmation()
    {
        return $this->newEmailConfirmation;
    }

    /**
     * @param mixed $newEmailConfirmation
     */
    public function setNewEmailConfirmation($newEmailConfirmation)
    {
        $this->newEmailConfirmation = $newEmailConfirmation;
    }

    public function generateNewEmailConfirmation()
    {
        $this->newEmailConfirmation = sha1(
            serialize([time(), $this->getId(), $this->getFullName(),])
        );
    }

    public function changeEmailConfirmed()
    {
        $this->setEmail($this->newEmail);
        $this->newEmail = null;
        $this->newEmailConfirmation = null;
    }

    /**
     * @return mixed
     */
    public function getShowEmail()
    {
        return $this->showEmail;
    }

    /**
     * @param mixed $showEmail
     */
    public function setShowEmail($showEmail)
    {
        $this->showEmail = $showEmail;
    }

    /**
     * @return bool
     */
    public function getShowPhone()
    {
        return $this->showPhone;
    }

    /**
     * @param bool $showPhone
     */
    public function setShowPhone($showPhone)
    {
        $this->showPhone = $showPhone;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    public function setPassword($password)
    {
        return parent::setPassword((string)$password);
    }

    /**
     * @param null|string $username
     *
     * @return object
     */
    public function setUsername($username = null)
    {
        $username = $username ?: $this->email;

        return parent::setUsername($username);
    }

}
