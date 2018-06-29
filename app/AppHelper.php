<?php

namespace App;

/**
 * Class Helper
 * @package App
 */
class AppHelper
{
    /**
     * @param $string
     * @return mixed
     */
    public static function removeSpecialCharacters($string) {
        return preg_replace('/[^A-Za-z0-9 ]/', '', $string);
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function removeAccentuation($string) {

        return preg_replace([
            "/(á|à|ã|â|ä)/",
            "/(Á|À|Ã|Â|Ä)/",
            "/(é|è|ê|ë)/",
            "/(É|È|Ê|Ë)/",
            "/(í|ì|î|ï)/",
            "/(Í|Ì|Î|Ï)/",
            "/(ó|ò|õ|ô|ö)/",
            "/(Ó|Ò|Õ|Ô|Ö)/",
            "/(ú|ù|û|ü)/",
            "/(Ú|Ù|Û|Ü)/",
            "/(ñ)/","/(Ñ)/"
        ], explode(" ","a A e E i I o O u U n N"), $string);
    }

    /**
     * Price formatter
     *
     * @param $value
     * @return string
     */
    public static function formatPrice($value)
    {
        if(strstr($value, '.'))
        {
            $exp = explode('.', $value);

            if(mb_strlen($exp[1]) == 1)
            {
                $decimal = $exp[1] . '0';

            } else {

                $decimal = $exp[1];
            }

            $price = $exp[0] . $decimal;

        } else {
            $price = $value . '00';
        }

        return $price;
    }

    /**
     * Insert blank spaces into string
     *
     * @param $quantity
     * @return string
     */
    public static function insertSpace($quantity)
    {
        $spaces = '';

        for ($i = 0; $i < $quantity; $i++)
        {
            $spaces .= ' ';
        }

        return $spaces;
    }

    /**
     * Insert characters to the left side of string
     *
     * @param $value
     * @param $qtd
     * @param $char
     * @return string
     */
    public static function insertChar($value, $qtd, $char, $custom = false)
    {
        if (mb_strlen($value) > $qtd)
        {
            return substr($value, 0, $qtd);
        }

        $quantity = $qtd - mb_strlen($value);
        $return = '';

        for ($i = 0; $i < $quantity; $i++)
        {
            $return .= $char;
        }

        if ($custom)
        {
            return $value . $return;
        }

        return $return . $value;
    }

    /**
     * Read array and return this values
     *
     * @param $values
     * @return string $result
     */
    public static function getValues($values)
    {
        return implode('', $values);
    }

    /**
     * Check if is a valid date
     *
     * @param $date
     * @return bool
     */
    public static function isValidDate($date)
    {
        return preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $date);
    }

    /**
     * @param $string
     * @return null|string|string[]
     */
    public static function removeCharacters($string) {
        return preg_replace('/[.\/-]/', '', $string);
   }

    /**
     * @param $string
     * @return null|string|string[]
     */
    public static function removeSpecificCharacters($string) {
        return preg_replace('/[^0-9]/', '', $string);
    }

    /**
     * @param $string
     * @return false|int
     */
    public static function removeCharactersSpecific($string) {
        return preg_match('/^[0-9]{5,5}([- ]?[0-9]{3,3})?$/', $string);
    }

    /**
     * Método recebe CPF e Formatar no Padrão xxx.xxx.xxx-xx, caso já seja formatado
     * ele retorna ele mesmo
     *
     * @param $cpf
     * @return string
     */
    public function formatCpf($cpf)
    {
        if (strlen($cpf) == 14) {
            return $cpf;
        } else {
            if (strlen($cpf) == 10) {
                $zero = '0' . $cpf;
                $partOne = substr($zero, 0, 3);
                $partTwo = substr($zero, 3, 3);
                $partThree = substr($zero, 6, 3);
                $partFour = substr($zero, 9, 2);
                $mountCPF = "$partOne.$partTwo.$partThree-$partFour";

                return $mountCPF;
            } else {
                $partOne = substr($cpf, 0, 3);
                $partTwo = substr($cpf, 3, 3);
                $partThree = substr($cpf, 6, 3);
                $partFour = substr($cpf, 9, 2);
                $mountCPF = "$partOne.$partTwo.$partThree-$partFour";

                return $mountCPF;
            }
        }
    }

    /**
     * Método para verificar se tem cpf nao tem zero inicial
     *
     * @param $string
     * @return mixed
     */
    public function verificarZero($string)
    {
        if (strlen($string) == 10) {
            $array = str_split($string, 1);
            $string = AppHelper::add($array);
            return $string;
        } else {
            return $string;
        }
    }

    /**
     * Adiciona um array em um Lista
     *
     * @param array $obj
     * @return array
     */
    public function add($obj = [])
    {
        $array = [1 => '0'];
        $newArray = array_merge($array , $obj);
        return $newArray;
    }

    /**
     * Método converte cpf em string adicionando zero na frente
     *
     * @param $string
     * @return mixed|string
     */
    public function formatString($string)
    {
        $format = AppHelper::verificarZero($string);
        if (is_array($format)) {
            $array = $format[0] . $format[1] . $format[2] . $format[3] . $format[4] . $format[5] . $format[6] . $format[7] .
                $format[8] . $format[9] . $format[10];
            return $array;
        } else {
            if (strlen($format) == 14) {
                return $format;
            }
        }
    }

}