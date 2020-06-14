<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';

    protected $fillable = [
        'user_id',
        'item_id',
        'ewarong_id',
        'harga',
        'qty',
        'date_pemesanan',
        'status',
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function item()
    {
        return $this->belongsTo('App\Item');
    }
    public function ewarong()
    {
        return $this->belongsTo('App\Ewarong');
    }
}