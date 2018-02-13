<?php


namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD"})
 * Валидируем уникальность имейла при его смене, нужен отдельный валидатор потому что мы вешаем его на 1 поле, а валидируем другое.
 */
class IsUniqueEmail extends Constraint
{
    public $invalidMessage = 'message.email.already_registred';

    public function validatedBy()
    {
        return 'useremail_validator';
    }
}