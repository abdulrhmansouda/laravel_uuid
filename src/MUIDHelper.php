<?php

namespace MUID;

use Illuminate\Support\Facades\DB;

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

    public static  function generateMUIDByModel($model_class_name, $column_name = 'muid'): string
    {
        $collections = collect($model_class_name::get_muid_columns());
        $column = $collections->where('column_name', $column_name)->first();
        $muid_length = (isset($column['length']) && is_numeric($column['length'])) ? $column['length'] : 10;
        $muid_charset = (isset($column['charset']) && is_string($column['charset'])) ? $column['charset'] : '0123456789abcdefghijklmnopqrstuvwxyz-_';
        do {
            $unique_code = MUIDHelper::generateRandomString($muid_length, $muid_charset);
        } while ($model_class_name::where($column_name, $unique_code)->exists());
        return $unique_code;
    }

    public static  function generateMUIDByTable($table_name, $column_name = 'muid', $column_length = 10, $charset = '0123456789abcdefghijklmnopqrstuvwxyz-_'): string
    {
        do {
            $unique_code = MUIDHelper::generateRandomString($column_length, $charset);
        } while (DB::table($table_name)->where($column_name, $unique_code)->exists());

        return $unique_code;
    }
}
