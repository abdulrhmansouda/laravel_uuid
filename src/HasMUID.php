<?php

namespace MUID;

trait HasMUID
{
    protected static function get_muid_columns(): array
    {
        return [
            'muid'
        ];
    }

    protected static function bootHasMUID()
    {
        foreach (static::get_muid_columns() as $column_name) {

            static::creating(function ($record) use ($column_name) {
                $unique_code = MUIDHelper::generateRandomString();
                while (static::where($column_name, $unique_code)->exists()) {
                    $unique_code = MUIDHelper::generateRandomString();
                }
                $record->{$column_name} = $unique_code;
            });
        }
    }
}
