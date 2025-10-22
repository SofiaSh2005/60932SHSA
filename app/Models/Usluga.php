<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usluga extends Model
{
    use HasFactory;

    protected $table = 'usluga';

    protected $fillable = ['nazvanie', 'stoimost'];

    // Одна услуга может встречаться во многих сеансах через промежуточную таблицу
    public function seanss()
    {
        return $this->belongsToMany(Seans::class, 'okazannaya_usluga');
    }

}
