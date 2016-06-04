<?php

namespace Antoree\Models;

use Illuminate\Database\Eloquent\Model;

class ResultTest extends Model
{
    protected $table = 'result_tests';
    protected $fillable = ['result', 'user_id', 'test_id'];
}
