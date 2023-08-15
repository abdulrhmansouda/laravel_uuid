<?php

namespace MUID;

trait HasMUID
{
    protected static function get_muid_columns(): array
    {
        return [
            [
                'column_name'   => 'muid',
                'length'        => 10,
                'charset'       => '0123456789abcdefghijklmnopqrstuvwxyz-_',
            ]
        ];
    }

    protected static function bootHasMUID()
    {
        foreach (static::get_muid_columns() as $column) {
            static::creating(function ($record) use ($column) {
                $column_name = $column['column_name'];
                $muid_length = (isset($column['length']) && is_numeric($column['length'])) ? $column['length'] : 10;
                $muid_charset = (isset($column['charset']) && is_string($column['charset'])) ? $column['charset'] : '0123456789abcdefghijklmnopqrstuvwxyz-_';
                do {
                    $unique_code = MUIDHelper::generateRandomString($muid_length, $muid_charset);
                } while (static::where($column_name, $unique_code)->exists());
                $record->{$column_name} = $unique_code;
            });
        }
    }
}
