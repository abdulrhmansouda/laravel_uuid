<?php

namespace MUID;

trait HasMUID
{
    protected function get_muid_columns(): array
    {
        return [
            'muid'
        ];
    }

    protected function initializeHasMUID()
    {
        foreach($this->get_muid_columns() as $column_name){
            $this->registerModelEvent('creating', function ($record)use($column_name) {
                $uniqueCode = MUIDHelper::generateRandomString();
                
                while ($this->where($column_name, $uniqueCode)->exists()) {
                    $uniqueCode = MUIDHelper::generateRandomString();
                }
                
                $record->$column_name = $uniqueCode;
            });
        }
    }
}
