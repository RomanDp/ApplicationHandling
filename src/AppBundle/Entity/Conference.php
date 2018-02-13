<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\Timestampable;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
 * @ORM\Table(name="conferences")
 * @ORM\Entity
 */
class Conference
{

    const MAX_ALLOWED_LANGUAGES_COUNT = 3;

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="publication_id", type="string", length=3)
     * @Assert\NotBlank(message="field.not_blank")
     */
    protected $publicationId;

    /**
     * @var \DateTime
     * @ORM\Column(name="start_at", type="date")
     * @Assert\NotBlank(message="field.not_blank")
     */
    protected $startAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="end_at", type="date")
     * @Assert\NotBlank(message="field.not_blank")
     */
    protected $endAt;

    /**
     * @var string
     * @ORM\Column(name="name_ru", type="string", length=400)
     * @Assert\Expression(
     *     "this.checkNames() == true"
     * )
     */
    protected $nameRu;

    /**
     * @var string
     * @ORM\Column(name="name_en", type="string", length=400)
     * @Assert\Expression(
     *     "this.checkNames() == true"
     * )
     */
    protected $nameEn;

    /**
     * @var string
     * @ORM\Column(name="name_uk", type="string", length=400)
     * @Assert\Expression(
     *     "this.checkNames() == true"
     * )
     */
    protected $nameUk;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\ParticipationType", mappedBy="conference")
     */
    protected $participationTypes;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Application", mappedBy="conference")
     */
    protected $applications;

    /**
     * @var Collection|TextBlock
     * @ORM\OneToMany(targetEntity="TextBlock", mappedBy="conference", indexBy="slug", cascade={"persist"}, orphanRemoval=true)
     */
    protected $textBocks;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Session", mappedBy="conference")
     */
    protected $sessions;

    /**
     * @var integer
     * @ORM\Column(name="crm_id", type="integer", nullable=true)
     * @Assert\NotBlank(message="field.not_blank")
     * @Assert\Regex(
     *    pattern="/^[0-9]+$/i",
     *    match=true,
     *    message="Поле должно содержать только цифры."
     * )
     */
    protected $crmId;

    /**
     * @var string
     * @ORM\Column(name="participants_sorted_by", type="string", length=50);
     */
    protected $participantsSortedBy;

    /**
     * @var integer
     * @ORM\Column(name="top_margin", type="integer", nullable=false, options={"default": 28})
     * @Assert\NotBlank(message="field.not_blank")
     * @Assert\Regex(
     *    pattern="/^[0-9]+$/i",
     *    match=true,
     *    message="Поле должно содержать только цифры."
     * )
     */
    protected $topMargin;

    /**
     * @var integer
     * @ORM\Column(name="text_height", type="integer", nullable=false, options={"default": 50})
     * @Assert\NotBlank(message="field.not_blank")
     * @Assert\Regex(
     *    pattern="/^[0-9]+$/i",
     *    match=true,
     *    message="Поле должно содержать только цифры."
     * )
     */
    protected $textHeight;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false, length=10, options={"default": "#ff0000"})
     * @Assert\NotBlank()
     */
    protected $nameColor;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false, length=10, options={"default": "#000000"})
     * @Assert\NotBlank()
     */
    protected $companyColor;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false, length=10, options={"default": "#858080"})
     * @Assert\NotBlank()
     */
    protected $countryColor;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=false, options={"default": ""})
     */
    protected $recipientsRu;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=false, options={"default": ""})
     */
    protected $recipientsUk;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=false, options={"default": ""})
     */
    protected $recipientsEn;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logoRu;

    /**
     * @Vich\UploadableField(mapping="conference_logo_ru", fileNameProperty="logoRu")
     * @Assert\Image(maxSize="1M")
     * @var File|UploadedFile
     */
    protected $uploadedLogoRu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logoUk;

    /**
     * @Vich\UploadableField(mapping="conference_logo_uk", fileNameProperty="logoUk")
     * @Assert\Image(maxSize="1M")
     * @var File|UploadedFile
     */
    protected $uploadedLogoUk;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logoEn;

    /**
     * @Vich\UploadableField(mapping="conference_logo_en", fileNameProperty="logoEn")
     * @Assert\Image(maxSize="1M")
     * @var File|UploadedFile
     */
    protected $uploadedLogoEn;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $locationRu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $locationUk;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $locationEn;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"default": ""})
     */
    private $contactsKeyword;

    /**
     * @ORM\Column(type="simple_array", options={"default": "ru,en"})
     * @Assert\NotBlank(message="field.language_required")
     * @var array
     */
    private $badgesLanguages = [];

    /**
     * @ORM\Column(type="simple_array", options={"default": "ru,en"})
     * @Assert\NotBlank(message="field.language_required")
     * @var array
     */
    private $vcardsLanguages = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=false, options={"default": "A3"})
     */
    private $badgeSheetFormat;

    /**
     * @ORM\Column(type="simple_array", length=255, nullable=false, options={"default": "UAH"})
     */
    private $currencies;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $longitude;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionRu;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionUk;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionEn;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $useAutoInvitations;

    /**
     * @var float
     * @ORM\Column(type="float", scale=1, options={"default" : 5.6})
     * @Assert\NotBlank(message="field.not_blank")
     */
    private $nameFontSize;

    /**
     * @var float
     * @ORM\Column(type="float", scale=1, options={"default" : 4.5})
     * @Assert\NotBlank(message="field.not_blank")
     */
    private $companyFontSize;

    /**
     * @var float
     * @ORM\Column(type="float", scale=1, options={"default" : 4.2})
     * @Assert\NotBlank(message="field.not_blank")
     */
    private $countryFontSize;

    /**
     * @var ArrayCollection|CompanyConferenceDetail[]
     * @ORM\OneToMany(targetEntity="CompanyConferenceDetail", mappedBy="conference")
     */
    private $companyConferenceDetails;

    public static $badgeSheetFormats = [
        'A3-8',
        'A3-12',
        'A4',
    ];

    use Timestampable;

    const PARTICIPANTS_SORTED_BY_FIRST_NAME_RU = 'firstNameRu';
    const PARTICIPANTS_SORTED_BY_LAST_NAME_RU = 'lastNameRu';
    const PARTICIPANTS_SORTED_BY_FIRST_NAME_EN = 'firstNameEn';
    const PARTICIPANTS_SORTED_BY_LAST_NAME_EN = 'lastNameEn';

    const DEFAULT_TOP_MARGIN = 28;
    const DEFAULT_TEXT_HEIGHT = 50;
    const DEFAULT_NAME_COLOR = '#ff0000';
    const DEFAULT_COMPANY_COLOR = '#000000';
    const DEFAULT_COUNTRY_COLOR = '#858080';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->participationTypes = new ArrayCollection();
        $this->participantsSortedBy = self::PARTICIPANTS_SORTED_BY_LAST_NAME_RU;

        $this->topMargin = self::DEFAULT_TOP_MARGIN;
        $this->textHeight = self::DEFAULT_TEXT_HEIGHT;
        $this->nameColor = self::DEFAULT_NAME_COLOR;
        $this->companyColor = self::DEFAULT_COMPANY_COLOR;
        $this->countryColor = self::DEFAULT_COUNTRY_COLOR;
        $this->recipientsRu = '';
        $this->recipientsUk = '';
        $this->recipientsEn = '';
        $this->updatedAt = new \DateTime();
        $this->badgesLanguages = ['ru', 'en'];
        $this->vcardsLanguages = ['ru', 'en'];
        $this->badgeSheetFormat = 'A3';
        $this->currencies = ['UAH'];
        $this->useAutoInvitations = false;

        $this->nameFontSize = 5.6;
        $this->companyFontSize = 4.5;
        $this->countryFontSize = 4.2;
    }

    /**
     * @return bool
     */
    public function checkNames()
    {
        return !empty($this->nameEn) || !empty($this->nameRu) || !empty($this->nameUk);
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Conference
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set publicationId
     *
     * @param string $publicationId
     *
     * @return Conference
     */
    public function setPublicationId($publicationId)
    {
        $this->publicationId = $publicationId;

        return $this;
    }

    /**
     * Get publicationId
     *
     * @return string
     */
    public function getPublicationId()
    {
        return $this->publicationId;
    }

    /**
     * Set startAt
     *
     * @param \DateTime $startAt
     *
     * @return Conference
     */
    public function setStartAt($startAt)
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * Get startAt
     *
     * @return \DateTime
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * Set endAt
     *
     * @param \DateTime $endAt
     *
     * @return Conference
     */
    public function setEndAt($endAt)
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * Get endAt
     *
     * @return \DateTime
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * Set nameRu
     *
     * @param string $nameRu
     *
     * @return Conference
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
     * @return Conference
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
     * @return Conference
     */
    public function setNameUk($nameUk)
    {
        $this->nameUk = (string)$nameUk;

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

    public function getName($prefferedLocale = null)
    {
        $languages = ['ru', 'uk', 'en'];
        if ($prefferedLocale) {
            $languages = array_unique(array_merge([$prefferedLocale], $languages));
        }
        foreach ($languages as $language) {
            $name = $this->{"getName$language"}();

            if ($name) {
                return $name;
            }
        }

        return $this->getNameRu();
    }

    /**
     * Add participationType
     *
     * @param ParticipationType $participationType
     *
     * @return Conference
     */
    public function addParticipationType(ParticipationType $participationType)
    {
        $this->participationTypes[] = $participationType;

        return $this;
    }

    /**
     * Remove participationType
     *
     * @param ParticipationType $participationType
     */
    public function removeParticipationType(ParticipationType $participationType)
    {
        $this->participationTypes->removeElement($participationType);
    }

    /**
     * Get participationTypes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParticipationTypes()
    {
        return $this->participationTypes;
    }

    /**
     * Set crmId
     *
     * @param integer $crmId
     *
     * @return Conference
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
     * Set participantsSortedBy
     *
     * @param string $participantsSortedBy
     *
     * @return Conference
     */
    public function setParticipantsSortedBy($participantsSortedBy)
    {
        $allowedValues = [
            self::PARTICIPANTS_SORTED_BY_FIRST_NAME_RU,
            self::PARTICIPANTS_SORTED_BY_LAST_NAME_RU,
            self::PARTICIPANTS_SORTED_BY_FIRST_NAME_EN,
            self::PARTICIPANTS_SORTED_BY_LAST_NAME_EN,
        ];

        if (!in_array($participantsSortedBy, $allowedValues)) {
            throw new \InvalidArgumentException('Invalid participantsSortedBy value: ' . $participantsSortedBy . '.');
        }

        $this->participantsSortedBy = $participantsSortedBy;

        return $this;
    }

    /**
     * Get participantsSortedBy
     *
     * @return string
     */
    public function getParticipantsSortedBy()
    {
        return $this->participantsSortedBy;
    }

    /**
     * @return int
     */
    public function getTopMargin()
    {
        return $this->topMargin;
    }

    /**
     * @param int $topMargin
     */
    public function setTopMargin($topMargin)
    {
        $this->topMargin = $topMargin;
    }

    /**
     * @return int
     */
    public function getTextHeight()
    {
        return $this->textHeight;
    }

    /**
     * @param int $textHeight
     */
    public function setTextHeight($textHeight)
    {
        $this->textHeight = $textHeight;
    }

    /**
     *  Get recipientsRu
     *
     * @return string
     */
    public function getRecipientsRu()
    {
        return $this->recipientsRu;
    }

    /**
     * Set recipientsRu
     *
     * @param string $recipientsRu
     *
     * @return Conference
     */
    public function setRecipientsRu($recipientsRu)
    {
        $this->recipientsRu = (string)$recipientsRu;

        return $this;
    }

    /**
     * Get recipientsUk
     *
     * @return string
     */
    public function getRecipientsUk()
    {
        return $this->recipientsUk;
    }

    /**
     * Set recipientsUk
     *
     * @param string $recipientsUk
     *
     * @return Conference
     */
    public function setRecipientsUk($recipientsUk)
    {
        $this->recipientsUk = (string)$recipientsUk;

        return $this;
    }

    /**
     * Get recipientsEn
     *
     * @return string
     */
    public function getRecipientsEn()
    {
        return $this->recipientsEn;
    }

    /**
     * Set recipientsEn
     *
     * @param string $recipientsEn
     *
     * @return Conference
     */
    public function setRecipientsEn($recipientsEn)
    {
        $this->recipientsEn = (string)$recipientsEn;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogoRu()
    {
        return $this->logoRu;
    }

    /**
     * @param mixed $logoRu
     */
    public function setLogoRu($logoRu)
    {
        $this->logoRu = $logoRu;
    }

    /**
     * @return File|UploadedFile
     */
    public function getUploadedLogoRu()
    {
        return $this->uploadedLogoRu;
    }

    /**
     * @param File|UploadedFile $uploadedLogoRu
     */
    public function setUploadedLogoRu(File $uploadedLogoRu = null)
    {
        $this->uploadedLogoRu = $uploadedLogoRu;
        if ($this->uploadedLogoRu instanceof UploadedFile) {
            $this->setUpdatedAt(new \DateTime());
        }
    }

    /**
     * @return mixed
     */
    public function getLogoUk()
    {
        return $this->logoUk;
    }

    /**
     * @param mixed $logoUk
     */
    public function setLogoUk($logoUk)
    {
        $this->logoUk = $logoUk;
    }

    /**
     * @return File|UploadedFile
     */
    public function getUploadedLogoUk()
    {
        return $this->uploadedLogoUk;
    }

    /**
     * @param File|UploadedFile $uploadedLogoUk
     */
    public function setUploadedLogoUk(File $uploadedLogoUk = null)
    {
        $this->uploadedLogoUk = $uploadedLogoUk;
        if ($this->uploadedLogoUk instanceof UploadedFile) {
            $this->setUpdatedAt(new \DateTime());
        }
    }

    /**
     * @return mixed
     */
    public function getLogoEn()
    {
        return $this->logoEn;
    }

    /**
     * @param mixed $logoEn
     */
    public function setLogoEn($logoEn)
    {
        $this->logoEn = $logoEn;
    }

    /**
     * @return File|UploadedFile
     */
    public function getUploadedLogoEn()
    {
        return $this->uploadedLogoEn;
    }

    /**
     * @param File|UploadedFile $uploadedLogoEn
     */
    public function setUploadedLogoEn(File $uploadedLogoEn = null)
    {
        $this->uploadedLogoEn = $uploadedLogoEn;
        if ($this->uploadedLogoEn instanceof UploadedFile) {
            $this->setUpdatedAt(new \DateTime());
        }
    }

    /**
     * @return string
     */
    public function getLocationRu()
    {
        return $this->locationRu;
    }

    /**
     * @param string $locationRu
     */
    public function setLocationRu($locationRu)
    {
        $this->locationRu = $locationRu;
    }

    /**
     * @return string
     */
    public function getLocationUk()
    {
        return $this->locationUk;
    }

    /**
     * @param string $locationUk
     */
    public function setLocationUk($locationUk)
    {
        $this->locationUk = $locationUk;
    }

    /**
     * @return string
     */
    public function getLocationEn()
    {
        return $this->locationEn;
    }

    /**
     * @param string $locationEn
     */
    public function setLocationEn($locationEn)
    {
        $this->locationEn = $locationEn;
    }

    /**
     * @return string
     */
    public function getContactsKeyword()
    {
        return $this->contactsKeyword;
    }

    /**
     * @param string $contactsKeyword
     */
    public function setContactsKeyword($contactsKeyword)
    {
        $this->contactsKeyword = $contactsKeyword;
    }

    /**
     * @Assert\All({
     *     @Assert\Email()
     * })
     */
    public function getRecipientsRuAsArray()
    {
        return $this->splitStringByLinebreaks($this->recipientsRu);
    }

    /**
     * @Assert\All({
     *     @Assert\Email()
     * })
     */
    public function getRecipientsUkAsArray()
    {
        return $this->splitStringByLinebreaks($this->recipientsUk);
    }

    /**
     * @Assert\All({
     *     @Assert\Email()
     * })
     */
    public function getRecipientsEnAsArray()
    {
        return $this->splitStringByLinebreaks($this->recipientsEn);
    }

    /**
     * @param $language
     *
     * @return string[]
     */
    public function getRecipientsAsArray($language)
    {
        $method = 'getRecipients' . $language . 'AsArray';

        return $this->$method();
    }

    public function hasAdditionalParticipationTypes()
    {
        return count($this->getAdditionalParticipationTypes()) > 0;
    }

    /**
     * @return ParticipationType[]
     */
    public function getAdditionalParticipationTypes()
    {
        $additionalTypes = [];
        foreach ($this->getParticipationTypes() as $participationType) {
            if ($participationType->getIsAdditional()) {
                $additionalTypes[] = $participationType;
            }
        }

        return $additionalTypes;
    }

    /**
     * @return Collection
     */
    public function getSessions()
    {
        return $this->sessions;
    }

    /**
     * @param string $text
     *
     * @return array lines
     */
    private function splitStringByLinebreaks($text)
    {
        $text = preg_split('/(\n\r|\n|\r)/', $text);

        return array_values(array_unique(array_filter(array_map('trim', $text))));
    }

    /**
     * @return array
     */
    public function getBadgesLanguages()
    {
        return array_filter($this->badgesLanguages);
    }

    /**
     * @param string $language
     */
    public function addBadgesLanguage($language)
    {
        if ($language) {
            $this->badgesLanguages[] = $language;
        }
    }

    /**
     * @param string $language
     */
    public function removeBadgesLanguage($language)
    {
        if (false !== $key = array_search($language, $this->badgesLanguages, true)) {
            array_splice($this->badgesLanguages, $key, 1);
        }
    }

    /**
     * @Assert\Count(min="1", max="3", minMessage="Необходимо выбрать хотя бы {{ limit }} язык.")
     * @return array
     */
    public function getNormalizedBadgesLanguages()
    {
        return array_values(array_unique(array_filter($this->badgesLanguages)));
    }

    /**
     * @ORM\PreFlush()
     */
    public function normalizeBadgesLanguages()
    {
        $this->badgesLanguages = $this->getNormalizedBadgesLanguages();
    }

    public function getFirstBadgesLanguage():string
    {
        $languages = $this->badgesLanguages;
        reset($languages);

        return current($languages);
    }

    public function getVcardsLanguages():array
    {
        return array_filter($this->vcardsLanguages);
    }

    public function addVcardsLanguage(string $language)
    {
        if ($language) {
            $this->vcardsLanguages[] = $language;
        }
    }

    public function removeVcardsLanguage(string $language)
    {
        if (false !== $key = array_search($language, $this->vcardsLanguages, true)) {
            array_splice($this->vcardsLanguages, $key, 1);
        }
    }

    /**
     * @Assert\Count(min="1", max="3", minMessage="Необходимо выбрать хотя бы {{ limit }} язык.")
     */
    public function getNormalizedVcardsLanguages():array
    {
        return array_values(array_unique(array_filter($this->vcardsLanguages)));
    }

    /**
     * @ORM\PreFlush()
     */
    public function normalizeVcardsLanguages()
    {
        $this->vcardsLanguages = $this->getNormalizedVcardsLanguages();
    }

    public function getFirstVcardsLanguage()
    {
        $languages = $this->vcardsLanguages;
        reset($languages);

        return current($languages);
    }

    /**
     * @return \DateTime
     */
    public function getDefaultMeetingStartAt()
    {
        $conferenceStartAt = clone $this->getStartAt();
        if ($conferenceStartAt > new \DateTime()) {
            $conferenceStartAt->setTime(10, 0);
        }

        return $conferenceStartAt;
    }

    /**
     * @return string
     */
    public function getBadgeSheetFormat()
    {
        return $this->badgeSheetFormat;
    }

    /**
     * @param string $badgeSheetFormat
     */
    public function setBadgeSheetFormat($badgeSheetFormat)
    {
        $this->badgeSheetFormat = (string)$badgeSheetFormat;
    }

    /**
     * @Assert\Count(min="1")
     * @return array
     */
    public function getCurrencies()
    {
        return $this->currencies;
    }

    /**
     * @param array $currencies
     */
    public function setCurrencies(array $currencies)
    {
        $this->currencies = $currencies;
    }

    /**
     * @return string
     */
    public function getNameColor()
    {
        return $this->nameColor;
    }

    /**
     * @param string $nameColor
     */
    public function setNameColor(?string $nameColor)
    {
        $this->nameColor = $nameColor;
    }

    /**
     * @return string
     */
    public function getCompanyColor()
    {
        return $this->companyColor;
    }

    /**
     * @param string $companyColor
     */
    public function setCompanyColor(?string $companyColor)
    {
        $this->companyColor = $companyColor;
    }

    /**
     * @return string
     */
    public function getCountryColor()
    {
        return $this->countryColor;
    }

    /**
     * @param string $countryColor
     */
    public function setCountryColor(?string $countryColor)
    {
        $this->countryColor = $countryColor;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return string
     */
    public function getDescriptionRu()
    {
        return $this->descriptionRu;
    }

    /**
     * @param string $descriptionRu
     */
    public function setDescriptionRu($descriptionRu)
    {
        $this->descriptionRu = $descriptionRu;
    }

    /**
     * @return string
     */
    public function getDescriptionUk()
    {
        return $this->descriptionUk;
    }

    /**
     * @param string $descriptionUk
     */
    public function setDescriptionUk($descriptionUk)
    {
        $this->descriptionUk = $descriptionUk;
    }

    /**
     * @return string
     */
    public function getDescriptionEn()
    {
        return $this->descriptionEn;
    }

    /**
     * @param string $descriptionEn
     */
    public function setDescriptionEn($descriptionEn)
    {
        $this->descriptionEn = $descriptionEn;
    }

    /**
     * @return boolean
     */
    public function getUseAutoInvitations()
    {
        return $this->useAutoInvitations;
    }

    /**
     * @param boolean $useAutoInvitations
     */
    public function setUseAutoInvitations($useAutoInvitations)
    {
        $this->useAutoInvitations = $useAutoInvitations;
    }

    /**
     * @return Collection|TextBlock[]
     */
    public function getTextBocks()
    {
        return $this->textBocks;
    }

    /**
     * @param TextBlock $textBock
     */
    public function addTextBock($textBock)
    {
        $textBock->setConference($this);
        $this->textBocks->set($textBock->getSlug(), $textBock);
    }

    /**
     * @param TextBlock $textBock
     */
    public function removeTextBock(TextBlock $textBock)
    {
        $this->textBocks->removeElement($textBock);
    }

    /**
     * @return float
     */
    public function getNameFontSize()
    {
        return $this->nameFontSize;
    }

    /**
     * @param float $nameFontSize
     */
    public function setNameFontSize($nameFontSize)
    {
        $this->nameFontSize = $nameFontSize;
    }

    /**
     * @return float
     */
    public function getCompanyFontSize()
    {
        return $this->companyFontSize;
    }

    /**
     * @param float $companyFontSize
     */
    public function setCompanyFontSize($companyFontSize)
    {
        $this->companyFontSize = $companyFontSize;
    }

    /**
     * @return float
     */
    public function getCountryFontSize()
    {
        return $this->countryFontSize;
    }

    /**
     * @param float $countryFontSize
     */
    public function setCountryFontSize($countryFontSize)
    {
        $this->countryFontSize = $countryFontSize;
    }

    /**
     * @return CompanyConferenceDetail[]|ArrayCollection
     */
    public function getCompanyConferenceDetails()
    {
        return $this->companyConferenceDetails;
    }
}
