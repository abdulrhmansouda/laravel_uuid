<?php

namespace UUID;

trait HasUUID
{
    protected static $uuid_column_name = 'uuid';
    protected static function bootHasUUID()
    {
        parent::boot();

        static::creating(function ($record) {
            $unique_code = UUIDHelper::generateRandomString();
            while (static::where(static::$uuid_column_name, $unique_code)->exists()) {
                $unique_code = UUIDHelper::generateRandomString();
            }
            $record->unique_code = $unique_code;
        });
    }
}
