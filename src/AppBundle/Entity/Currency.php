<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="currencies")
 * @ORM\Entity
 * @UniqueEntity(
 *     fields={"id"},
 *     errorPath="id",
 *     message="Валюта уже добавлена"
 * )
 */
class Currency
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="string", length=3, nullable=false, options={"fixed": true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName($language = 'en')
    {
        return Intl::getCurrencyBundle()->getCurrencyName($this->id, $language);
    }
}
