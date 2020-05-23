<?php

class Strings {

    /**
     * It strips all non-alpha numeric chars from a string
     * and replace them with white space 
     * 
     * the secound argument can be used to tell which special char to be replaced
     * with white space , in that way some-of-the-words can still be parsed as words
     * 
     * it also strips multiple white-space to single whitespace 
     * 
     * @param string $str
     * @param mixed $chars_to_replace_with_whitespace
     * @return string 
     */
    public static function to_alpha_numeric($str, $chars_to_replace_with_whitespace = false) {
        $str = $chars_to_replace_with_whitespace ? str_replace($chars_to_replace_with_whitespace, ' ', $str) : $str;
        $str = trim($str);
        return preg_replace('/[^a-zA-Z0-9\s]/', '', $str);
    }

    /**
     * format text , separated with dashes
     * @param type $str
     * @param type $cirilic
     * @return type 
     */
    public static function clean_for_url($str, $cirilic = false) {

        if ($cirilic) {

            Load::helper('cyrillic_latin');
            $str = CyrillicLatin::cyrillic2latin($str);
        }

        $str = str_replace(array("\r\n", "\r", "\n", "\t", '-', '.'), ' ', $str);
        $str = preg_replace('/[^a-zA-Z0-9-\s]/', '', $str);

        $str = trim($str);
        $str = strtolower($str);
        $str = preg_replace('!\s+!', ' ', $str);
        return str_replace(' ', '-', $str);
    }

    public static function htmlentities($utf8, $encodeTags = true) {
        $result = '';
        for ($i = 0; $i < strlen($utf8); $i++) {
            $char = $utf8[$i];
            $ascii = ord($char);
            if ($ascii < 128) {
                // one-byte character
                $result .= ($encodeTags) ? htmlentities($char) : $char;
            } else if ($ascii < 192) {
                // non-utf8 character or not a start byte
            } else if ($ascii < 224) {
                // two-byte character
                $result .= htmlentities(substr($utf8, $i, 2), ENT_QUOTES, 'UTF-8');
                $i++;
            } else if ($ascii < 240) {
                // three-byte character
                $ascii1 = ord($utf8[$i + 1]);
                $ascii2 = ord($utf8[$i + 2]);
                $unicode = (15 & $ascii) * 4096 +
                        (63 & $ascii1) * 64 +
                        (63 & $ascii2);
                $result .= "&#$unicode;";
                $i += 2;
            } else if ($ascii < 248) {
                // four-byte character
                $ascii1 = ord($utf8[$i + 1]);
                $ascii2 = ord($utf8[$i + 2]);
                $ascii3 = ord($utf8[$i + 3]);
                $unicode = (15 & $ascii) * 262144 +
                        (63 & $ascii1) * 4096 +
                        (63 & $ascii2) * 64 +
                        (63 & $ascii3);
                $result .= "&#$unicode;";
                $i += 3;
            }
        }
        return $result;
    }

    /**
     * It wraps an URL into an Anchor tag
     * @param type $url
     * @return type 
     */
    public static function url_to_anchor($url) {

        $in = array(
            '`((?:https?|ftp)://\S+[[:alnum:]]/?)`si',
            '`((?<!//)(www\.\S+[[:alnum:]]/?))`si'
        );
        $out = array(
            '<a href="$1" target="_blank"  rel="nofollow" >$1</a> ',
            '<a href="http://$1" target="_blank" rel="nofollow" >$1</a>'
        );
        return preg_replace($in, $out, $url);
    }

    /**
     * Replace newlines , tabs , multiple whitespace , strip tags and trim string
     * @param type $text
     * @return type 
     */
    public static function plain_text($text) {

        $text = str_replace(array("\r\n", "\r", "\n", "\t"), '', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = strip_tags($text);
        $text = trim($text);

        return $text;
    }

    /**
     * Shortens the text , good for preview texts
     * @param type $text
     * @param type $length
     * @return type 
     */
    public static function short($text, $length = 100) {
        if (mb_strlen($text, 'UTF-8') > $length) {
            return mb_substr($text, 0, $length, 'UTF-8') . ' ...';
        }
        return $text;
    }

    public static function smart_short($text, $words_count = 20, $text_length = 140) {

        $buffer = '';
        $delimiters = array(' ', ',', '.', '!', '?');

        $chars = self::get_chars($text);
        $br = 0;
        $count = count($chars);
        for ($i = 0; $i < $count; $i++) {
            $buffer .= $chars[$i];
            if (in_array($chars[$i], $delimiters)) {
                $br = $br + 1;
                if ($br >= $words_count and $i >= $text_length) {
                    $buffer .= "...";
                    break;
                }
            }
        }
        return $buffer;
    }

    public static function get_chars($jstring) {
        if (mb_strlen($jstring, 'UTF-8') == 0)
            return array();

        $ret = array();
        $alen = strlen($jstring);
        $char = '';
        for ($i = 0; $i < $alen; $i++) {
            $char .= $jstring[$i];
            if (mb_check_encoding($char, 'UTF-8')) {
                array_push($ret, $char);
                $char = '';
            }
        }

        return $ret;
    }

    public static function GUID() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

}

?>