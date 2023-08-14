<?php

namespace MUID;

trait HasMUID
{
    protected static $uuid_column_name = 'muid';
    protected static function bootHasUUID()
    {
        parent::boot();

        static::creating(function ($record) {
            $unique_code = MUIDHelper::generateRandomString();
            while (static::where(static::$uuid_column_name, $unique_code)->exists()) {
                $unique_code = MUIDHelper::generateRandomString();
            }
            $record->{static::$uuid_column_name} = $unique_code;
        });
    }
}
