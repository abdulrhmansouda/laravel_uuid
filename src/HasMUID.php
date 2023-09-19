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
                'charset'       => '0123456789abcdefghijklmnopqrstuvwxyz',
            ]
        ];
    }

    protected static function bootHasMUID()
    {
        foreach (static::get_muid_columns() as $column) {
            static::creating(function ($record) use ($column) {
                $column_name = $column['column_name'];
                $muid_length = (isset($column['length']) && is_numeric($column['length'])) ? $column['length'] : 10;
                $muid_charset = (isset($column['charset']) && is_string($column['charset'])) ? $column['charset'] : '0123456789abcdefghijklmnopqrstuvwxyz';
                do {
                    $unique_code = MUIDHelper::generateRandomString($muid_length, $muid_charset);
                } while (static::where($column_name, $unique_code)->exists());
                $record->{$column_name} = $unique_code;
            });
        }
    }

    public function generateMUID($column_names = ['muid'])
    {
        $collections = collect(self::get_muid_columns());
        foreach ($column_names as $column_name) {
            $column = $collections->where('column_name', $column_name)->first();
            $muid_length = (isset($column['length']) && is_numeric($column['length'])) ? $column['length'] : 10;
            $muid_charset = (isset($column['charset']) && is_string($column['charset'])) ? $column['charset'] : '0123456789abcdefghijklmnopqrstuvwxyz-_';
            do {
                $unique_code = MUIDHelper::generateRandomString($muid_length, $muid_charset);
            } while (static::where($column_name, $unique_code)->exists());
            $this->{$column_name} = $unique_code;
        }
    }

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array
     */
    public function uniqueIds()
    {
        return [$this->getKeyName()];
    }


    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        if (in_array($this->getKeyName(), $this->uniqueIds())) {
            return 'string';
        }

        return $this->keyType;
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        if (in_array($this->getKeyName(), $this->uniqueIds())) {
            return false;
        }

        return $this->incrementing;
    }
}
