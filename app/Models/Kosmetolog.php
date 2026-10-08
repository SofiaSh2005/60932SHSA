<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kosmetolog extends Model
{
    use HasFactory;

    protected $table = 'kosmetolog';

    protected $fillable = ['fio', 'specialnost', 'telefon', 'nachalo_raboty', 'konec_raboty'];


    public function seanss()
    {
        return $this->hasMany(Seans::class);
    }

    public function uslugi()
    {
        return $this->belongsToMany(Usluga::class, 'kosmetolog_usluga', 'kosmetolog_id', 'usluga_id');
    }

}
