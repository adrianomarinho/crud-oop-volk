<?php

namespace App\Helpers;

/*
 * Classe para manipular validações de dados
 *
 * @author Fábio Assunção <fabio@fabioassuncao.com.br>
 * @date April 20, 2016
 */
class Functions
{

    /**
     * Higieniza variaveis
     * @param  mixed    dados higienizados
     * @param  string $type tipo de validação / higienização
     * @return string       string higienizada
     *
     * Tipos:
     *     email - Remove todos caracteres exceto letras, dígitos e #$%&'*+-/=^_`!{|}~@.[].
     *     encoded - Seqüência de URL-codificada, opcionalmente remove ou codifica caracteres especiais
     *     quotes
     *     float - Remove todos caracteres exceto dígitos, + - e, opcionalmente, eE..
     *     int - Remove todos caracteres exceto dígitos, mais e sinal de menos
     *     special_chars - HTML-escape '"<> & e caracteres com valor ASCII menor que 32, opcionalmente remove ou codifica outros caracteres especiais
     *     full_special_chars - Equivalente a chamar htmlspecialchars () com ENT_QUOTES
     *     string - Remove tags, opcionalmente remove ou codifica caracteres especiais.
     *     stripped - Alias of "string" filter
     *     url - Remove all characters except letters, digits and $-_.+!*'(),{}|\\^~[]`<>#%";/?:@&=.
     *     unsafe_raw - Do nothing, optionally strip or encode special characters. This filter is also aliased to FILTER_DEFAULT.
     */
    public static function sanitize($data, $type = 'string')
    {
        switch ($type) {

            case 'email':
                $filter = FILTER_SANITIZE_EMAIL;
                break;

            case 'encoded':
                $filter = FILTER_SANITIZE_ENCODED;
                break;

            case 'quotes':
                $filter = FILTER_SANITIZE_MAGIC_QUOTES;
                break;

            case 'float':
                $filter = FILTER_SANITIZE_NUMBER_FLOAT;
                break;

            case 'int':
                $filter = FILTER_SANITIZE_NUMBER_INT;
                break;

            case 'special_chars':
                $filter = FILTER_SANITIZE_SPECIAL_CHARS;
                break;

            case 'full_special_chars':
                $filter = FILTER_SANITIZE_FULL_SPECIAL_CHARS;
                break;

            case 'string':
                $filter = FILTER_SANITIZE_STRING;
                break;

            case 'stripped':
                $filter = FILTER_SANITIZE_STRIPPED;
                break;

            case 'url':
                $filter = FILTER_SANITIZE_URL;
                break;

            case 'unsafe_raw':
                $filter = FILTER_UNSAFE_RAW;
                break;
        }

        return filter_var($data, $filter);
    }

    public static function sanitizeFromInt($string)
    {
        return preg_replace("/[^0-9]/", "", $string);
    }


    /**
     * Higieniza array
     * @param  array $array   array de dados para ser higienizado
     * @param  string $filter filtro
     * @return mixed    dados higienizados
     */
    public static function sanitizeArray($array, $filter = 'string')
    {
        foreach ($array as $chave => $valor) {
            if (is_array($valor)) {
                $valor = self::filterArray($valor, $filter);
            } else {
                $array[$chave] = self::sanitize($valor, $filter);
            }
        }
        return $array;
    }

    /**
     * Reset the mbstring internal encoding to a users previously set encoding.
     *
     * @see mbstringBinarySafeEncoding()
     *
     */
    public static function resetMbstringEncoding()
    {
        self::mbstringBinarySafeEncoding(true);
    }

    /**
     * Set the mbstring internal encoding to a binary safe encoding when func_overload
     * is enabled.
     *
     * When mbstring.func_overload is in use for multi-byte encodings, the results from
     * strlen() and similar functions respect the utf8 characters, causing binary data
     * to return incorrect lengths.
     *
     * This function overrides the mbstring encoding to a binary-safe encoding, and
     * resets it to the users expected encoding afterwards through the
     * `resetMbstringEncoding` function.
     *
     * It is safe to recursively call this function, however each
     * `mbstringBinarySafeEncoding()` call must be followed up with an equal number
     * of `resetMbstringEncoding()` calls.
     *
     *
     * @see resetMbstringEncoding()
     *
     * @param bool $reset Optional. Whether to reset the encoding back to a previously-set encoding.
     *                    Default false.
     */
    public static function mbstringBinarySafeEncoding($reset = false)
    {
        static $encodings = [];
        static $overloaded = null;

        if (is_null($overloaded)) {
            $overloaded = function_exists('mb_internal_encoding') && (ini_get('mbstring.func_overload') & 2);
        }

        if (false === $overloaded) {
            return;
        }

        if (!$reset) {
            $encoding = mb_internal_encoding();
            array_push($encodings, $encoding);
            mb_internal_encoding('ISO-8859-1');
        }

        if ($reset && $encodings) {
            $encoding = array_pop($encodings);
            mb_internal_encoding($encoding);
        }
    }

    /**
     * Checks to see if a string is utf8 encoded.
     *
     * NOTE: This function checks for 5-Byte sequences, UTF8
     * has Bytes Sequences with a maximum length of 4.
     *
     * @author bmorel at ssi dot fr (modified)
     *
     * @param string $str The string to be checked
     * @return bool True if $str fits a UTF-8 model, false otherwise.
     */
    public static function seemsUtf8($str)
    {
        self::mbstringBinarySafeEncoding();
        $length = strlen($str);
        self::resetMbstringEncoding();
        for ($i=0; $i < $length; $i++) {
            $c = ord($str[$i]);
            if ($c < 0x80) {
                $n = 0;
            } // 0bbbbbbb
            elseif (($c & 0xE0) == 0xC0) {
                $n=1;
            } // 110bbbbb
            elseif (($c & 0xF0) == 0xE0) {
                $n=2;
            } // 1110bbbb
            elseif (($c & 0xF8) == 0xF0) {
                $n=3;
            } // 11110bbb
            elseif (($c & 0xFC) == 0xF8) {
                $n=4;
            } // 111110bb
            elseif (($c & 0xFE) == 0xFC) {
                $n=5;
            } // 1111110b
            else {
                return false;
            } // Does not match any model
            for ($j=0; $j<$n; $j++) { // n bytes matching 10bbbbbb follow ?
                if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80)) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Converte todos os caracteres acentuados em caracteres ASCII
     *
     * Se não houver caracteres acentuados, em seguida, a string dada é devolvido
     *
     * @param string $string Texto que pode ter caracteres acentuados
     * @return string $string filtrada
     */
    public static function removeAccents($string)
    {
        if (!preg_match('/[\x80-\xff]/', $string)) {
            return $string;
        }

        if (self::seemsUtf8($string)) {
            $chars = [
                // Decompositions for Latin-1 Supplement
                chr(194).chr(170) => 'a', chr(194).chr(186) => 'o',
                chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
                chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
                chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
                chr(195).chr(134) => 'AE',chr(195).chr(135) => 'C',
                chr(195).chr(136) => 'E', chr(195).chr(137) => 'E',
                chr(195).chr(138) => 'E', chr(195).chr(139) => 'E',
                chr(195).chr(140) => 'I', chr(195).chr(141) => 'I',
                chr(195).chr(142) => 'I', chr(195).chr(143) => 'I',
                chr(195).chr(144) => 'D', chr(195).chr(145) => 'N',
                chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
                chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
                chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
                chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
                chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
                chr(195).chr(158) => 'TH',chr(195).chr(159) => 's',
                chr(195).chr(160) => 'a', chr(195).chr(161) => 'a',
                chr(195).chr(162) => 'a', chr(195).chr(163) => 'a',
                chr(195).chr(164) => 'a', chr(195).chr(165) => 'a',
                chr(195).chr(166) => 'ae',chr(195).chr(167) => 'c',
                chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
                chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
                chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
                chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
                chr(195).chr(176) => 'd', chr(195).chr(177) => 'n',
                chr(195).chr(178) => 'o', chr(195).chr(179) => 'o',
                chr(195).chr(180) => 'o', chr(195).chr(181) => 'o',
                chr(195).chr(182) => 'o', chr(195).chr(184) => 'o',
                chr(195).chr(185) => 'u', chr(195).chr(186) => 'u',
                chr(195).chr(187) => 'u', chr(195).chr(188) => 'u',
                chr(195).chr(189) => 'y', chr(195).chr(190) => 'th',
                chr(195).chr(191) => 'y', chr(195).chr(152) => 'O',
                // Decompositions for Latin Extended-A
                chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
                chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
                chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
                chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
                chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
                chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
                chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
                chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
                chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
                chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
                chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
                chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
                chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
                chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
                chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
                chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
                chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
                chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
                chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
                chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
                chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
                chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
                chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
                chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
                chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
                chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
                chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
                chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
                chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
                chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
                chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
                chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
                chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
                chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
                chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
                chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
                chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
                chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
                chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
                chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
                chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
                chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
                chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
                chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
                chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
                chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
                chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
                chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
                chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
                chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
                chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
                chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
                chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
                chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
                chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
                chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
                chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
                chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
                chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
                chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
                chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
                chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
                chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
                chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
                // Decompositions for Latin Extended-B
                chr(200).chr(152) => 'S', chr(200).chr(153) => 's',
                chr(200).chr(154) => 'T', chr(200).chr(155) => 't',
                // Euro Sign
                chr(226).chr(130).chr(172) => 'E',
                // GBP (Pound) Sign
                chr(194).chr(163) => '',
                // Vowels with diacritic (Vietnamese)
                // unmarked
                chr(198).chr(160) => 'O', chr(198).chr(161) => 'o',
                chr(198).chr(175) => 'U', chr(198).chr(176) => 'u',
                // grave accent
                chr(225).chr(186).chr(166) => 'A', chr(225).chr(186).chr(167) => 'a',
                chr(225).chr(186).chr(176) => 'A', chr(225).chr(186).chr(177) => 'a',
                chr(225).chr(187).chr(128) => 'E', chr(225).chr(187).chr(129) => 'e',
                chr(225).chr(187).chr(146) => 'O', chr(225).chr(187).chr(147) => 'o',
                chr(225).chr(187).chr(156) => 'O', chr(225).chr(187).chr(157) => 'o',
                chr(225).chr(187).chr(170) => 'U', chr(225).chr(187).chr(171) => 'u',
                chr(225).chr(187).chr(178) => 'Y', chr(225).chr(187).chr(179) => 'y',
                // hook
                chr(225).chr(186).chr(162) => 'A', chr(225).chr(186).chr(163) => 'a',
                chr(225).chr(186).chr(168) => 'A', chr(225).chr(186).chr(169) => 'a',
                chr(225).chr(186).chr(178) => 'A', chr(225).chr(186).chr(179) => 'a',
                chr(225).chr(186).chr(186) => 'E', chr(225).chr(186).chr(187) => 'e',
                chr(225).chr(187).chr(130) => 'E', chr(225).chr(187).chr(131) => 'e',
                chr(225).chr(187).chr(136) => 'I', chr(225).chr(187).chr(137) => 'i',
                chr(225).chr(187).chr(142) => 'O', chr(225).chr(187).chr(143) => 'o',
                chr(225).chr(187).chr(148) => 'O', chr(225).chr(187).chr(149) => 'o',
                chr(225).chr(187).chr(158) => 'O', chr(225).chr(187).chr(159) => 'o',
                chr(225).chr(187).chr(166) => 'U', chr(225).chr(187).chr(167) => 'u',
                chr(225).chr(187).chr(172) => 'U', chr(225).chr(187).chr(173) => 'u',
                chr(225).chr(187).chr(182) => 'Y', chr(225).chr(187).chr(183) => 'y',
                // tilde
                chr(225).chr(186).chr(170) => 'A', chr(225).chr(186).chr(171) => 'a',
                chr(225).chr(186).chr(180) => 'A', chr(225).chr(186).chr(181) => 'a',
                chr(225).chr(186).chr(188) => 'E', chr(225).chr(186).chr(189) => 'e',
                chr(225).chr(187).chr(132) => 'E', chr(225).chr(187).chr(133) => 'e',
                chr(225).chr(187).chr(150) => 'O', chr(225).chr(187).chr(151) => 'o',
                chr(225).chr(187).chr(160) => 'O', chr(225).chr(187).chr(161) => 'o',
                chr(225).chr(187).chr(174) => 'U', chr(225).chr(187).chr(175) => 'u',
                chr(225).chr(187).chr(184) => 'Y', chr(225).chr(187).chr(185) => 'y',
                // acute accent
                chr(225).chr(186).chr(164) => 'A', chr(225).chr(186).chr(165) => 'a',
                chr(225).chr(186).chr(174) => 'A', chr(225).chr(186).chr(175) => 'a',
                chr(225).chr(186).chr(190) => 'E', chr(225).chr(186).chr(191) => 'e',
                chr(225).chr(187).chr(144) => 'O', chr(225).chr(187).chr(145) => 'o',
                chr(225).chr(187).chr(154) => 'O', chr(225).chr(187).chr(155) => 'o',
                chr(225).chr(187).chr(168) => 'U', chr(225).chr(187).chr(169) => 'u',
                // dot below
                chr(225).chr(186).chr(160) => 'A', chr(225).chr(186).chr(161) => 'a',
                chr(225).chr(186).chr(172) => 'A', chr(225).chr(186).chr(173) => 'a',
                chr(225).chr(186).chr(182) => 'A', chr(225).chr(186).chr(183) => 'a',
                chr(225).chr(186).chr(184) => 'E', chr(225).chr(186).chr(185) => 'e',
                chr(225).chr(187).chr(134) => 'E', chr(225).chr(187).chr(135) => 'e',
                chr(225).chr(187).chr(138) => 'I', chr(225).chr(187).chr(139) => 'i',
                chr(225).chr(187).chr(140) => 'O', chr(225).chr(187).chr(141) => 'o',
                chr(225).chr(187).chr(152) => 'O', chr(225).chr(187).chr(153) => 'o',
                chr(225).chr(187).chr(162) => 'O', chr(225).chr(187).chr(163) => 'o',
                chr(225).chr(187).chr(164) => 'U', chr(225).chr(187).chr(165) => 'u',
                chr(225).chr(187).chr(176) => 'U', chr(225).chr(187).chr(177) => 'u',
                chr(225).chr(187).chr(180) => 'Y', chr(225).chr(187).chr(181) => 'y',
                // Vowels with diacritic (Chinese, Hanyu Pinyin)
                chr(201).chr(145) => 'a',
                // macron
                chr(199).chr(149) => 'U', chr(199).chr(150) => 'u',
                // acute accent
                chr(199).chr(151) => 'U', chr(199).chr(152) => 'u',
                // caron
                chr(199).chr(141) => 'A', chr(199).chr(142) => 'a',
                chr(199).chr(143) => 'I', chr(199).chr(144) => 'i',
                chr(199).chr(145) => 'O', chr(199).chr(146) => 'o',
                chr(199).chr(147) => 'U', chr(199).chr(148) => 'u',
                chr(199).chr(153) => 'U', chr(199).chr(154) => 'u',
                // grave accent
                chr(199).chr(155) => 'U', chr(199).chr(156) => 'u',
            ];

            // Used for locale-specific rules
            //$locale = get_locale();
            $locale = 'en_US';

            if ('de_DE' == $locale) {
                $chars[ chr(195).chr(132) ] = 'Ae';
                $chars[ chr(195).chr(164) ] = 'ae';
                $chars[ chr(195).chr(150) ] = 'Oe';
                $chars[ chr(195).chr(182) ] = 'oe';
                $chars[ chr(195).chr(156) ] = 'Ue';
                $chars[ chr(195).chr(188) ] = 'ue';
                $chars[ chr(195).chr(159) ] = 'ss';
            } elseif ('da_DK' === $locale) {
                $chars[ chr(195).chr(134) ] = 'Ae';
                $chars[ chr(195).chr(166) ] = 'ae';
                $chars[ chr(195).chr(152) ] = 'Oe';
                $chars[ chr(195).chr(184) ] = 'oe';
                $chars[ chr(195).chr(133) ] = 'Aa';
                $chars[ chr(195).chr(165) ] = 'aa';
            }

            $string = strtr($string, $chars);
        } else {
            $chars = [];
            // Assume ISO-8859-1 if not UTF-8
            $chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
                .chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
                .chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
                .chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
                .chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
                .chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
                .chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
                .chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
                .chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
                .chr(252).chr(253).chr(255);

            $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";

            $string = strtr($string, $chars['in'], $chars['out']);
            $double_chars = [];
            $double_chars['in'] = [chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254)];
            $double_chars['out'] = ['OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th'];
            $string = str_replace($double_chars['in'], $double_chars['out'], $string);
        }

        return $string;
    }

    public static function cleanString($text)
    {
        $utf8 = array(
            '/[áàâãªä]/u' => 'a',
            '/[ÁÀÂÃÄ]/u' => 'A',
            '/[ÍÌÎÏ]/u' => 'I',
            '/[íìîï]/u' => 'i',
            '/[éèêë]/u' => 'e',
            '/[ÉÈÊË]/u' => 'E',
            '/[óòôõºö]/u' => 'o',
            '/[ÓÒÔÕÖ]/u' => 'O',
            '/[úùûü]/u' => 'u',
            '/[ÚÙÛÜ]/u' => 'U',
            '/ç/' => 'c',
            '/Ç/' => 'C',
            '/ñ/' => 'n',
            '/Ñ/' => 'N',
            '/–/' => '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u' => ' ', // Literally a single quote
            '/[“”«»„]/u' => ' ', // Double quote
            '/ /' => ' ', // nonbreaking space (equiv. to 0x160)
        );
        return preg_replace(array_keys($utf8), array_values($utf8), $text);
    }

    /**
     * Envia as mensagens de sistema para a view
     * @param  string $url destino
     * @param  array $mensagem
     * @param  string $class    class alert-* css bootstrap
     */
    public static function sistemaMensagem($mensagem, $class = 'warning')
    {
        if (Session::get('mensagemSistema')) {
            return;
        }

        switch ($class) {
            case 'warning':
                $icon = 'fa-warning';
                break;

            case 'danger':
                $icon = 'fa-ban';
                break;

            case 'success':
                $icon = 'fa-check';
                break;

            case 'info':
                $icon = 'fa-info';
                break;
        }

        if (is_array($mensagem)) {
            if (!isset($mensagem['titulo']) || empty($mensagem['titulo'])) {
                $mensagem['titulo'] = '';
            }

            if (!isset($mensagem['mensagem']) || empty($mensagem['mensagem'])) {
                $mensagem['mensagem'] = '';
            }
        }

        if (is_string($mensagem)) {
            $strMensagem = $mensagem;
            $mensagem = [
                'titulo' => $strMensagem,
                'mensagem' => ''
            ];
        }

        $dadosMensagem = [
            'class' => $class,
            'icone' => $icon,
            'titulo' => $mensagem['titulo'],
            'mensagem' => $mensagem['mensagem']
        ];

        Session::set('mensagemSistema', $dadosMensagem);
    }

    /**
     * Mensagens de avisos
     * @param  string $url destino
     * @param  array $mensagem
     */
    public static function alertaAviso($mensagem)
    {
        self::sistemaMensagem($mensagem, 'warning');
    }

    /**
     * Mensagens de erros
     * @param  string $url destino
     * @param  array $mensagem
     */
    public static function alertaErro($mensagem)
    {
        self::sistemaMensagem($mensagem, 'danger');
    }

    /**
     * Mensagens de sucesso
     * @param  string $url destino
     * @param  array $mensagem
     */
    public static function alertaSucesso($mensagem)
    {
        self::sistemaMensagem($mensagem, 'success');
    }

    /**
     * Mensagens de informações
     * @param  string $url destino
     * @param  array $mensagem
     */
    public static function alertaInfo($mensagem)
    {
        self::sistemaMensagem($mensagem, 'info');
    }

    /**
     * Checa as mensagens de erros enviados para a view atrvés de http/post
     */
    public static function getMensagemSistema()
    {
        $mensagemSistema = Session::pull('mensagemSistema');
        if (!empty($mensagemSistema)) {
            $view = 'base::notifications.default';
            return view($view, $mensagemSistema);
        }

        return "";
    }
}
