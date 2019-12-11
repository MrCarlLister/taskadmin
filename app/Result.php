<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    //

    protected $table = 'tasks_results';
    protected $fillable = [
        'duration',
        'result'
    ];

    protected $dates = [
        'ran_at'
    ];
}
