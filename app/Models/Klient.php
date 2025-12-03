<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klient extends Model
{
    use HasFactory;

    protected $table = 'klient';

    protected $fillable = ['fio', 'telefon'];


    public function seanss()
    {
        return $this->hasMany(Seans::class);
    }
}
