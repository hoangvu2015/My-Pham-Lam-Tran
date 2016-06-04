<?php

namespace Antoree\Models\Themes;

use Illuminate\Database\Eloquent\Model;

class ThemeWidget extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'theme_widgets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['widget_name', 'theme_name', 'placeholder', 'translatable', 'constructing_data', 'active', 'order'];

    public function getParamsAttribute()
    {
        if (empty($this->attributes['constructing_data'])) return [];

        $params = json_decode($this->attributes['constructing_data'], true);
        if ($params === false) return [];

        return $params;
    }

    public function getHasThemeAttribute()
    {
        return !empty($this->attributes['theme_name']);
    }

    public function getNameAttribute()
    {
        return $this->attributes['widget_name'];
    }

    public function getThemeAttribute()
    {
        return $this->attributes['theme_name'];
    }

    public function scopeForDisplay($query, $placeholder = '')
    {
        if (!empty($placeholder)) {
            $query->where('placeholder', $placeholder);
        }
        $query->where('active', true)->orderBy('order', 'asc')->orderBy('created_at', 'asc');

        return $query;
    }

    public function render()
    {
        return Widget::doRender($this);
    }

    public function register()
    {
        Widget::doRegister($this);
    }
}
