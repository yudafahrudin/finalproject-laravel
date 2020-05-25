<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    protected $fillable = [
        'name', 'code',
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}