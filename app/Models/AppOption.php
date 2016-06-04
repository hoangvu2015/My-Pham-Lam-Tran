<?php

namespace Antoree\Models;

use Illuminate\Database\Eloquent\Model;

class AppOption extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'app_options';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'data_type', 'value'
    ];

    public function getRawValueAttribute()
    {
        return $this->attributes['value'];
    }

    public function setValueAttribute($value)
    {
        $type = null;
        $value = escObject($value, $type);
        $this->attributes['value'] = $value;
        $this->attributes['data_type'] = $type;
    }

    public function getValueAttribute()
    {
        switch ($this->attributes['data_type']) {
            case 'array':
                return json_decode($this->attributes['value'], true);
            case 'bool':
                return boolval($this->attributes['value']);
            case 'int':
                return intval($this->attributes['value']);
            case 'float':
                return floatval($this->attributes['value']);
        }

        return $this->attributes['value'];
    }
}
