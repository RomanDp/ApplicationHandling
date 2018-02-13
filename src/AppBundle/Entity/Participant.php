<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="participants")
 * @ORM\Entity
 * @UniqueEntity(
 *     fields={"crmId"},
 *     groups={"Default", "ApplicationParticipants"},
 *     errorPath="crmId",
 *     message="Участник уже зарегистрирован"
 * )
 */
class Participant
{
    const PARTICIPANTS_SYNC_LOCK_NAME = 'participants_sync';

    const BATCH_ACTION_PRINT_BADGE = 1;
    const BATCH_ACTION_SEND_INVITE = 2;
    const BATCH_ACTION_DELETE = 3;


    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var CompanyConferenceDetail
     * @ORM\ManyToOne(targetEntity="CompanyConferenceDetail", inversedBy="participants")
     * @ORM\JoinColumn(name="company_conference_id", referencedColumnName="id")
     * @Assert\NotBlank(message="field.not_blank")
     */
    private $companyConferenceDetail;

    //FIXME: Add NotBlank
    /**
     * @var Person
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="participants")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $person;

    /**
     * @var ParticipationType
     * @ORM\ManyToOne(targetEntity="ParticipationType", inversedBy="participants")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotBlank(groups={"Default", "ApplicationParticipants", "light_participant"})
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="field.not_blank")
     * @Assert\Email(message="field.required_contain_email", groups={"Default", "ApplicationParticipants", "light_participant"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="field.not_blank")
     */
    private $phone;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex(
     *    pattern="/^[0-9]+$/i",
     *    match=true,
     *    message="field.required_only_numbers"
     * )
     * @Assert\NotBlank(message="field.not_blank")
     */
    private $position;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true, unique=true)
     * @Assert\NotBlank(groups={"ApplicationParticipants"}, message="field.not_blank")
     */
    private $crmId;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    private $invoiceId;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $arrivedAt;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true, options={"default" : false})
     */
    protected $isPaid;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true, options={"default" : 0})
     * @Assert\Length(
     *     maxMessage="field.max_length_dept_amount",
     *     min="1",
     *     max="10"
     * )
     */
    protected $deptAmount;

    /**
     * Participant constructor.
     */
    public function __construct()
    {
        $this->position = 0;
        $this->deptAmount = 0;
        $this->email = '';
        $this->phone = '';
        $this->isPaid = false;
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
     * @return Participant
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
     * @return Participant
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
     * Set position
     *
     * @param integer $position
     *
     * @return Participant
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return CompanyConferenceDetail
     */
    public function getCompanyConferenceDetail()
    {
        return $this->companyConferenceDetail;
    }

    /**
     * @param CompanyConferenceDetail $companyConferenceDetail
     */
    public function setCompanyConferenceDetail(CompanyConferenceDetail $companyConferenceDetail)
    {
        $this->companyConferenceDetail = $companyConferenceDetail;
    }

    /**
     * Set person
     *
     * @param Person $person
     *
     * @return Participant
     */
    public function setPerson(Person $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * @param Person $person
     */
    public function populatetFromPerson(Person $person)
    {
        $this->setPerson($person);
        $this->setEmail($person->getEmail());
        $this->setPhone($person->getPhone());
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
     * Set type
     *
     * @param ParticipationType $type
     *
     * @return Participant
     */
    public function setType(ParticipationType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return ParticipationType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set crmId
     *
     * @param integer $crmId
     *
     * @return Participant
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
     * Set invoiceId
     *
     * @param integer $invoiceId
     *
     * @return Participant
     */
    public function setInvoiceId($invoiceId)
    {
        $this->invoiceId = $invoiceId;

        return $this;
    }

    /**
     * Get invoiceId
     *
     * @return integer
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    /**
     * @return \DateTime
     */
    public function getArrivedAt()
    {
        return $this->arrivedAt;
    }

    /**
     * @param \DateTime $arrivedAt
     */
    public function setArrivedAt(\DateTime $arrivedAt = null)
    {
        $this->arrivedAt = $arrivedAt;
    }

    /**
     * @return bool
     */
    public function isArrived()
    {
        return $this->arrivedAt !== null;
    }

    /**
     * @return bool
     */
    public function isIsPaid()
    {
        return $this->isPaid;
    }

    /**
     * @param bool $isPaid
     */
    public function setIsPaid(bool $isPaid)
    {
        $this->isPaid = $isPaid;
    }

    /**
     * @return mixed
     */
    public function getDeptAmount()
    {
        return $this->deptAmount;
    }

    /**
     * @param mixed $deptAmount
     */
    public function setDeptAmount($deptAmount)
    {
        $this->deptAmount = $deptAmount;
    }

}
