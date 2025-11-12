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
        'data_vremya',
    ];

    public function klient()
    {
        return $this->belongsTo(Klient::class, 'klient_id');
    }

    public function kosmetolog()
    {
        return $this->belongsTo(Kosmetolog::class, 'kosmetolog_id');
    }

    public function okazannyeUslugi()
    {
        return $this->hasMany(OkazannayaUsluga::class, 'seans_id');
    }
}
