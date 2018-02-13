<?php

namespace AppBundle\Twig\Extension;

class NormalizeUserInputDataExtension extends \Twig_Extension
{
    /**
     * @var array
     */
    private $phoneCodes;

    public function __construct($phoneCodes)
    {
        $this->phoneCodes = $phoneCodes;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('normalize_user_input_data', array($this, 'getString')),
        );
    }

    public function getString($string, $field)
    {
        //pattern => type
        $associates = [
            '^phone$' => 'phone',
            '^contact$' => 'contact',
            '^legalCompanyName$' => 'contact',
            '^name.{2}' => 'contact',
            '^director.{2}' => 'contact',
            '^address.{2}' => 'string',
            '^legalAddress$' => 'string',
            '^activities.{2}' => 'string',
            '^position.{2}' => 'string',

            //TODO: Need?
            '^firstName.{2}' => 'contact',
            '^lastName.{2}' => 'contact',
        ];

        foreach ($associates as $pattern => $type) {
            if (preg_match('/' . $pattern . '/ui', $field)) {
                $string = $this->normalize($string, $type);
                break;
            }
        }

        return $string;
    }


    //type: string, contact, phone
    public function normalize($string, $type)
    {
        $string = trim($string);
        $string = preg_replace('/\s{2,}/ui', ' ', $string);

        if (!$string) {
            return $string;
        }

        switch ($type) {
            case 'string':
                if (mb_strlen($string) > 5 && self::hasMostPartStringIsUppercaseLetters($string, 50)) {
                    return self::mb_ucfirst($string);
                }

                break;

            case 'contact':
                if (self::hasMostPartStringIsUppercaseLetters($string, 50)) {
                    return mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
                }

                break;

            case 'phone':
                return $this->normalizePhoneString($string);

            default:
                throw new \InvalidArgumentException(sprintf('Type: %s is not defined.', $type));
        }

        return $string;
    }

    private function normalizePhoneString($string)
    {

        $phones = preg_split('/[,;]/u', preg_replace('/[^\d,;]/u', '', $string));

        foreach ($phones as $key => $phone) {
            if (mb_strlen($phone) > 7) {
                $phone = preg_replace('/^00/u', '', $phone);
            }

            if (mb_strlen($phone) > 7) {
                //ищем номер
                $foundCode = null;
                foreach ($this->phoneCodes as $code) {
                    if (preg_match('/^'.$code.'/ui', $phone)) {
                        if (null === $foundCode || mb_strlen($foundCode) < mb_strlen($code)) {
                            $foundCode = $code;
                        }
                    }
                }

                if (null !== $foundCode) {
                    $phone = mb_substr($phone, mb_strlen($foundCode));
                    $phone = $foundCode. ' '.$phone;
                }
            }

            $phones[$key] = $phone;
        }

        return implode('; ', $phones);
    }

    private static function mb_ucfirst($string)
    {
        $first = mb_substr($string, 0, 1, 'UTF-8');//первая буква
        $last = mb_substr($string, 1);//все кроме первой буквы
        $first = mb_strtoupper($first, 'UTF-8');
        $last = mb_strtolower($last, 'UTF-8');

        return $first . $last;
    }

    private static function hasMostPartStringIsUppercaseLetters($string, $percent)
    {
        preg_match_all('/[AА-ЯZЁ+]/u', $string, $matches);
        $count = count($matches[0]);

        if (!$count) {
            return false;
        }

        return ((($count / mb_strlen($string)) * 100) >= $percent);
    }
}
