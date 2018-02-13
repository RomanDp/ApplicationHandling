<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="participation_types")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class ParticipationType
{

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Conference
     * @ORM\ManyToOne(targetEntity="Conference", inversedBy="participationTypes")
     * @ORM\JoinColumn(name="conference_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $conference;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Expression(
     *     "this.checkTitles() == true"
     * )
     */
    private $titleRu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Expression(
     *     "this.checkTitles() == true"
     * )
     */
    private $titleEn;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Expression(
     *     "this.checkTitles() == true"
     * )
     */
    private $titleUk;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="participation_type_image", fileNameProperty="image")
     * @Assert\Image()
     * @var File|UploadedFile
     */
    protected $uploadedImage;

    /**
     * @ORM\Column(type="boolean", options={"default" : true})
     */
    private $isActive;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $isAdditional;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Regex(
     *    pattern="/^[0-9]+$/i",
     *    match=true,
     *    message="field.required_only_numbers"
     * )
     * @Assert\NotBlank(message="field.not_blank")
     */
    private $crmId;

    /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Participant", mappedBy="type")
     */
    private $participants;

    /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\ApplicationParticipant", mappedBy="participationType")
     */
    private $applicationParticipants;

    /**
     * @var ArrayCollection|ApplicationParticipationType[]
     *
     * @ORM\OneToMany(targetEntity="ApplicationParticipationType", mappedBy="participationType", cascade={"persist"}, orphanRemoval=true)
     */
    private $applicationParticipationTypes;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Regex(
     *    pattern="/^[0-9]+$/i",
     *    match=true,
     *    message="field.required_only_numbers"
     * )
     */
    private $position;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->applicationParticipants = new ArrayCollection();
        $this->applicationParticipationTypes = new ArrayCollection();
        $this->isActive = true;
        $this->isAdditional = false;
    }

    /**
     * @return bool
     */
    public function checkTitles()
    {
        return !empty($this->titleEn) || !empty($this->titleRu) || !empty($this->titleUk);
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
     * Set titleRu
     *
     * @param string $titleRu
     *
     * @return ParticipationType
     */
    public function setTitleRu($titleRu)
    {
        $this->titleRu = (string)$titleRu;

        return $this;
    }

    /**
     * Get titleRu
     *
     * @return string
     */
    public function getTitleRu()
    {
        return $this->titleRu;
    }

    /**
     * Set titleEn
     *
     * @param string $titleEn
     *
     * @return ParticipationType
     */
    public function setTitleEn($titleEn)
    {
        $this->titleEn = (string)$titleEn;

        return $this;
    }

    /**
     * Get titleEn
     *
     * @return string
     */
    public function getTitleEn()
    {
        return $this->titleEn;
    }

    /**
     * Set titleUk
     *
     * @param string $titleUk
     *
     * @return ParticipationType
     */
    public function setTitleUk($titleUk)
    {
        $this->titleUk = (string)$titleUk;

        return $this;
    }

    /**
     * Get titleUk
     *
     * @return string
     */
    public function getTitleUk()
    {
        return $this->titleUk;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return ParticipationType
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return File|UploadedFile
     */
    public function getUploadedImage()
    {
        return $this->uploadedImage;
    }

    /**
     * @param File|UploadedFile $uploadedImage
     *
     * @return $this
     */
    public function setUploadedImage(File $uploadedImage)
    {
        $this->uploadedImage = $uploadedImage;

        return $this;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return ParticipationType
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    public function getIsAdditional()
    {
        return $this->isAdditional;
    }

    public function setIsAdditional($isAdditional)
    {
        $this->isAdditional = $isAdditional;
    }

    /**
     * Set crmId
     *
     * @param integer $crmId
     *
     * @return ParticipationType
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
     * Set conference
     *
     * @param Conference $conference
     *
     * @return ParticipationType
     */
    public function setConference(Conference $conference = null)
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

    /**
     * Add participant
     *
     * @param Participant $participant
     *
     * @return ParticipationType
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * Add applicationParticipant
     *
     * @param ApplicationParticipant $applicationParticipant
     *
     * @return ParticipationType
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
        $applicationParticipationType->setParticipationType($this);
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
     * @param string $lang
     *
     * @return string
     */
    public function getTitle($lang = 'ru')
    {
        return $this->{"getTitle$lang"}();
    }

    /**
     * @param string $lang
     *
     * @return string
     */
    public function getTitles()
    {
        $title = '';
        if ($this->getTitleRu()) {
            $title .= $this->getTitleRu();
        }
        if ($this->getTitleUk()) {
            $title .= ' / ' . $this->getTitleUk();
        }
        if ($this->getTitleEn()) {
            $title .= ' / ' . $this->getTitleEn();
        }

        return $title;
    }

    /**
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param integer $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @param integer $position
     *
     * @return boolean
     */
    public function isExtremumPosition($position)
    {
        return $this->position === $position;
    }
}
