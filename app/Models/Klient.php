<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Seans;

class Klient extends Model
{
    use HasFactory;

    protected $table = 'klient';

    protected $fillable = ['fio', 'telefon'];

    public function seans()
    {
        return $this->hasMany(Seans::class, 'klient_id');
    }
}
