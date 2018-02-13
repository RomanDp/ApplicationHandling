<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="application_participation_type",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_application_participation_type", columns={"application_id", "participation_type_id"} )}
 * )
 * @ORM\Entity
 */
class ApplicationParticipationType
{
    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Application
     *
     * @ORM\ManyToOne(targetEntity="Application", inversedBy="applicationParticipationTypes")
     * @ORM\JoinColumn(name="application_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    private $application;

    /**
     * @var ParticipationType
     *
     * @ORM\ManyToOne(targetEntity="ParticipationType", inversedBy="applicationParticipationTypes")
     * @ORM\JoinColumn(name="participation_type_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    private $participationType;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param Application $application
     */
    public function setApplication(Application $application)
    {
        $this->application = $application;
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