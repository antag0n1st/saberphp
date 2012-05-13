<?php
/**
 * Class that converts cyrilic letters into the coresponding latin letters
 *
 * @author Antagonist
 */
class CyrillicLatin {
    
    private static $cyrillic2latin = array(
        "ѓ" => "gj",
        "ж" => "zh",
        "ѕ" => "dz",
        "љ" => "lj",
        "њ" => "nj",
        "ќ" => "kj",
        "ч" => "ch",
        "џ" => "dj",
        "ш" => "sh",
        "Ѓ" => "Gj",
        "Ж" => "Zh",
        "Ѕ" => "Dz",
        "Љ" => "Lj",
        "Њ" => "Nj",
        "Ќ" => "Kj",
        "Ч" => "Ch",
        "Џ" => "Dj",
        "Ш" => "Sh",
        "а" => "a",
        "б" => "b",
        "в" => "v",
        "г" => "g",
        "д" => "d",
        "е" => "e",
        "з" => "z",
        "и" => "i",
        "ј" => "j",
        "к" => "k",
        "л" => "l",
        "м" => "m",
        "н" => "n",
        "о" => "o",
        "п" => "p",
        "р" => "r",
        "с" => "s",
        "т" => "t",
        "у" => "u",
        "ф" => "f",
        "х" => "h",
        "ц" => "c",
        "А" => "A",
        "Б" => "B",
        "В" => "V",
        "Г" => "G",
        "Д" => "D",
        "Е" => "E",
        "З" => "Z",
        "И" => "I",
        "Ј" => "J",
        "К" => "K",
        "Л" => "L",
        "М" => "M",
        "Н" => "N",
        "О" => "O",
        "П" => "P",
        "Р" => "R",
        "С" => "S",
        "Т" => "T",
        "У" => "U",
        "Ф" => "F",
        "Х" => "H",
        "Ц" => "C",
    );

    public static function cyrillic2latin($str) {
        foreach (self::$cyrillic2latin as $key => $value) {
            $str = str_replace($key, $value, $str);
        }
        return $str;
    }
}

?>