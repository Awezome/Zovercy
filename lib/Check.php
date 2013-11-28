<?php

class Check {

    //from php cookbook
    static function email($email) {
        $qtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';
        $dtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
        $atom = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
        $quoted_pair = '\\x5c[\\x00-\\x7f]';
        $domain_literal = "\\x5b($dtext|$quoted_pair)*\\x5d";
        $quoted_string = "\\x22($qtext|$quoted_pair)*\\x22";
        $domain_ref = $atom;
        $sub_domain = "($domain_ref|$domain_literal)";
        $word = "($atom|$quoted_string)";
        $domain = "$sub_domain(\\x2e$sub_domain)*";
        $local_part = "$word(\\x2e$word)*";
        $addr_spec = "$local_part\\x40$domain";
        return preg_match("!^$addr_spec$!", $email);
    }

    static function exist($str) {
        return isset($str) && strlen($str);
    }

    static function number($num) {
        return ctype_digit($num) ? intval($num) : 0;
    }

    static function text($string) {
        return htmlspecialchars($string);
    }

    static function isEmpty($data) {
        if (empty($data)) {
            Func::jump(THIS_HOST);
        }
    }

}
