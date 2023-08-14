<?php

namespace UUID;

class UUIDHelper
{
    public static  function generateRandomString($length = 10, $charset = '0123456789abcdefghijklmnopqrstuvwxyz-_')
    {
        $randomString = '';
        $charsetLength = strlen($charset);

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $charset[rand(0, $charsetLength - 1)];
        }

        return $randomString;
    }
}
