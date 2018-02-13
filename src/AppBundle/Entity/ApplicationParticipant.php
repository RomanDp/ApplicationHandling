<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="application_participants")
 * @ORM\Entity
 */
class ApplicationParticipant
{

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Application
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Application", inversedBy="applicationParticipants")
     * @ORM\JoinColumn(name="application_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotBlank(message="field.not_blank")
     */
    private $application;

    /**
     * @var Person
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="applicationParticipants")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotBlank(message="field.not_blank")
     */
    private $person;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="field.not_blank", groups={"LangRUStep-3"})
     */
    private $firstNameRu;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="field.not_blank", groups={"LangRUStep-3"})
     */
    private $lastNameRu;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="field.not_blank", groups={"LangENStep-3"})
     */
    private $firstNameEn;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="field.not_blank", groups={"LangENStep-3"})
     */
    private $lastNameEn;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="field.not_blank", groups={"LangUKStep-3"})
     */
    private $firstNameUk;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="field.not_blank", groups={"LangUKStep-3"})
     */
    private $lastNameUk;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="field.not_blank", groups={"Step-3"})
     * @Assert\Email(message="field.required_contain_email", groups={"Step-3"})
     * @Assert\Length(
     *      max = 250,
     *      maxMessage = "field.max_length",
     *      groups={"Step-3"}
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="field.not_blank", groups={"Step-3"})
     * @Assert\Length(
     *     max = 250,
     *     maxMessage = "field.max_length",
     *     groups={"Step-3"}
     * )
     */
    private $phone;

    /**
     * @var ParticipationType
     * @ORM\ManyToOne(targetEntity="ParticipationType", inversedBy="applicationParticipants")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotBlank(message="field.not_blank", groups={"Step-3"})
     */
    private $participationType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Expression(
     *     "this.checkPosition() == true"
     * )
     * @Assert\NotBlank(message="field.not_blank", groups={"LangRUStep-3"})
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "field.max_length", groups={"LangRUStep-3"}
     * )
     */
    private $positionRu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Expression(
     *     "this.checkPosition() == true"
     * )
     * @Assert\NotBlank(message="field.not_blank", groups={"LangENStep-3"})
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "field.max_length", groups={"LangENStep-3"}
     * )
     */
    private $positionEn;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Expression(
     *     "this.checkPosition() == true"
     * )
     * @Assert\NotBlank(message="field.not_blank", groups={"LangUKStep-3"})
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "field.max_length", groups={"LangUKStep-3"}
     * )
     */
    private $positionUk;

    public function __construct()
    {
        $this->email = '';
        $this->phone = '';

        $this->positionEn = '';
        $this->positionRu = '';
        $this->positionUk = '';

        $this->lastNameEn = '';
        $this->lastNameRu = '';
        $this->lastNameUk = '';

        $this->firstNameEn = '';
        $this->firstNameRu = '';
        $this->firstNameUk = '';
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
     * Set firstNameRu
     *
     * @param string $firstNameRu
     *
     * @return ApplicationParticipant
     */
    public function setFirstNameRu($firstNameRu)
    {
        $this->firstNameRu = (string)$firstNameRu;

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
     * @return ApplicationParticipant
     */
    public function setLastNameRu($lastNameRu)
    {
        $this->lastNameRu = (string)$lastNameRu;

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
     * Set firstNameEn
     *
     * @param string $firstNameEn
     *
     * @return ApplicationParticipant
     */
    public function setFirstNameEn($firstNameEn)
    {
        $this->firstNameEn = (string)$firstNameEn;

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
     * @return ApplicationParticipant
     */
    public function setLastNameEn($lastNameEn)
    {
        $this->lastNameEn = (string)$lastNameEn;

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
     * Set firstNameUk
     *
     * @param string $firstNameUk
     *
     * @return ApplicationParticipant
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
     * @return ApplicationParticipant
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

    public function getFullName($language = null)
    {
        if (!$language){
            $language = $this->application->getLanguage();
        }

        return $this->{"getFirstName$language"}().' '.$this->{"getLastName$language"}();
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return ApplicationParticipant
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
     * @return ApplicationParticipant
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
     * Set request
     *
     * @param Application $application
     *
     * @return ApplicationParticipant
     */
    public function setApplication(Application $application = null)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Get request
     *
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Set person
     *
     * @param Person $person
     *
     * @return ApplicationParticipant
     */
    public function setPerson(Person $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Set participationType
     *
     * @param ParticipationType $participationType
     *
     * @return ApplicationParticipant
     */
    public function setParticipationType(ParticipationType $participationType = null)
    {
        $this->participationType = $participationType;

        return $this;
    }

    /**
     * Get participationType
     *
     * @return ParticipationType
     */
    public function getParticipationType()
    {
        return $this->participationType;
    }

    public function getPositionRu()
    {
        return $this->positionRu;
    }

    public function setPositionRu($positionRu)
    {
        $this->positionRu = (string)$positionRu;

        return $this;
    }

    public function getPositionEn()
    {
        return $this->positionEn;
    }

    public function setPositionEn($positionEn)
    {
        $this->positionEn = (string)$positionEn;

        return $this;
    }

    public function getPositionUk()
    {
        return $this->positionUk;
    }

    public function setPositionUk($positionUk)
    {
        $this->positionUk = (string)$positionUk;

        return $this;
    }

    /**
     * Returns first not empty firstName and lastName.
     *
     * @return string
     */
    public function __toString()
    {
        $firstNames = array_filter(array_map('trim', [$this->firstNameRu, $this->firstNameUk, $this->firstNameEn]));
        $lastNames = array_filter(array_map('trim', [$this->lastNameRu, $this->lastNameUk, $this->lastNameEn]));

        $firstName = reset($firstNames);
        $lastName = reset($lastNames);

        return implode(' ', array_filter([$firstName, $lastName])) ?: '-';
    }
}
