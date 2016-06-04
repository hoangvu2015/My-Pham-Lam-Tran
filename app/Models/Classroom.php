<?php

namespace Antoree\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    const STATUS_UNPUBLISHED = "lock";
    const STATUS_PUBLISHED = "open";
    const STATUS_TRIAL = "trial";
    const STATUS_CLOSED = "closed";
    protected $table = 'classrooms';

    protected $fillable = [
        'classname','slug','hours_estimate','hours_real','note','url_detail','status','created_by','closed_by','closed_date'
    ];



}
