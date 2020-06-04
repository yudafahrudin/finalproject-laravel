<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rpk extends Model
{
    protected $table = 'rpk';

    protected $fillable = [
        'user_id',
        'telp',
        'nama_kios',
        'latitude',
        'longtitude',
        'jam_buka',
        'image_url',
        'lokasi',
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}