<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seans extends Model
{
    use HasFactory;

    protected $table = 'seans';

    protected $fillable = [
        'klient_id',
        'kosmetolog_id',
        'usluga_id',
        'data_vremya',
        'data_okonchaniya',
        'status',
    ];

    protected $casts = [
        'data_vremya' => 'datetime',
        'data_okonchaniya' => 'datetime',
    ];

    public function klient()
    {
        return $this->belongsTo(Klient::class, 'klient_id');
    }

    public function kosmetolog()
    {
        return $this->belongsTo(Kosmetolog::class, 'kosmetolog_id');
    }

    public function okazannayaUsluga()
    {
        return $this->hasMany(OkazannayaUsluga::class, 'seans_id');
    }

    public function vybrannayaUsluga()
    {
        return $this->belongsTo(Usluga::class, 'usluga_id');
    }

    public function usluga()
    {
        return $this->belongsToMany(Usluga::class, 'okazannaya_usluga', 'seans_id', 'usluga_id');
    }
}
