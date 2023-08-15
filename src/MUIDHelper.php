<?php

namespace MUID;

class MUIDHelper
{
    public static  function generateRandomString($length, $charset)
    {
        $randomString = '';
        $charsetLength = strlen($charset);

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $charset[rand(0, $charsetLength - 1)];
        }

        return $randomString;
    }
}
