<?php

namespace AppBundle\Validator\Constraints;

use AppBundle\Entity\Person;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManager;

class IsUniqueEmailValidator extends ConstraintValidator
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint)
    {
        if ($this->em->getRepository(Person::class)->findOneBy(['email' => $value])) {
            $this->context->addViolation($constraint->invalidMessage);
        }
    }

}
