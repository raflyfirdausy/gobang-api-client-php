<?php
defined('BASEPATH') or exit('No direct script access allowed');

function faker()
{
    return Faker\Factory::create('id_ID');
}

function aaa()
{
    $CI = &get_instance();
    $userData = $this->m_data->getWhere("nip", $CI->session->userdata("login")->nip);
    $userData = $this->m_data->getData("admin")->row();
    return $userData;
}

function coba()
{
    return "hehehee";
}

function d($x)
{
    return die(json_encode($x));
}

if (!function_exists('RFL_ENCRYPT')) {
    function RFL_ENCRYPT($plain_text)
    {
        return bin2hex(base64_encode($plain_text));
    }
}

if (!function_exists('RFL_DECRYPT')) {
    function RFL_DECRYPT($chiper)
    {
        return base64_decode(hex2bin($chiper));
    }
}

if (!function_exists('numberToRomawi')) {
    function numberToRomawi($number)
    {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if ($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }
}
