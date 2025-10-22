<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seans extends Model
{
    use HasFactory;

    protected $table = 'seans';

    protected $fillable = ['data', 'klient_id', 'kosmetolog_id'];

    // Один сеанс принадлежит клиенту
    public function klient()
    {
        return $this->belongsTo(Klient::class);
    }

    public function kosmetolog()
    {
        return $this->belongsTo(Kosmetolog::class);
    }

    public function uslugis()
    {
        return $this->belongsToMany(Usluga::class, 'okazannaya_usluga');
    }


}
