<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klient extends Model
{
    use HasFactory;

    protected $table = 'klient';

    protected $fillable = ['fio', 'telefon'];

    // Один клиент может иметь много сеансов
    public function seanss()
    {
        return $this->hasMany(Seans::class);
    }
}
