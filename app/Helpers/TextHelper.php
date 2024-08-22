<?php

namespace App\Helpers;

class TextHelper
{
    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function generateRandomNumber($length = 10)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function wordLimit($string, $limit = 10, $end = '...')
    {
        $words = explode(' ', $string);
        if (count($words) > $limit) {
            return implode(' ', array_slice($words, 0, $limit)) . $end;
        }
        return $string;
    }

    public static function truncate($string, $length = 100, $end = '...')
    {
        return mb_strimwidth($string, 0, $length, $end);
    }

    public static function textLimit($string, $limit = 500, $end = '...')
    {
        // strip tags to avoid breaking any html
        $string = strip_tags($string);
        if (strlen($string) > $limit) {

            // truncate string
            $stringCut = substr($string, 0, $limit);
            $endPoint = strrpos($stringCut, ' ');

            //if the string doesn't contain any space then it will cut without word basis.
            $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $string .= $end;
        }

        return $string;
    }
}
