<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="participant_company",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_conference_participation_type", columns={"conference_id", "participation_type_id"} )}
 * )
 * @ORM\Entity
 */
class ParticipantCompany
{
    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Conference
     *
     * @ORM\ManyToOne(targetEntity="Conference")
     * @ORM\JoinColumn(name="conference_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $conference;

    /**
     * @var ParticipationType
     *
     * @ORM\ManyToOne(targetEntity="ParticipationType")
     * @ORM\JoinColumn(name="participation_type_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $participationType;

    public function getId()
    {
        return $this->id;
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
     * @return ParticipationType
     */
    public function getParticipationType()
    {
        return $this->participationType;
    }

    /**
     * @param ParticipationType $participationType
     */
    public function setParticipationType(ParticipationType $participationType)
    {
        $this->participationType = $participationType;
    }
}