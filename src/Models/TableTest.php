<?php

namespace MUID\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MUID\HasMUID;

class TableTest extends Model
{
    use HasFactory;
    use HasMUID;
    protected $table = 'table_test';
    protected static function get_muid_columns(): array
    {
        return [
            [
                'column_name'   => 'muid',
            ],
            [
                'column_name'   => 'unique_code',
                'length'    => 5,
                'charset'   => '0123456789',
            ],
        ];
    }
}
