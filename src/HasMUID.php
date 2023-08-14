<?php

namespace MUID;

trait HasMUID
{
    protected static $muid_column_name = 'muid';
    protected static function bootHasMUID()
    {
        parent::boot();

        static::creating(function ($record) {
            $unique_code = MUIDHelper::generateRandomString();
            while (static::where(static::$muid_column_name, $unique_code)->exists()) {
                $unique_code = MUIDHelper::generateRandomString();
            }
            $record->{static::$muid_column_name} = $unique_code;
        });
    }
}
