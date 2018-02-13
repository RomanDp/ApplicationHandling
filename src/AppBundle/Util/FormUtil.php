<?php

namespace AppBundle\Util;

class FormUtil
{

    public static function suffixField($name, $language)
    {
        return $name . ucfirst(mb_strtolower($language));
    }

    public static function suffixLabel($label, $language)
    {
        return $label . ' (' . self::getLangTitle($language) . ')';
    }

    public static function getLangTitle($lang)
    {
        switch (mb_strtolower($lang)) {
            case 'en':
                return 'англ.';

            case 'uk':
                return 'укр.';

            case 'ru':
                return 'рус.';
        }
    }
}
