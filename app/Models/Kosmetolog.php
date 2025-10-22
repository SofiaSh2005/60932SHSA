<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kosmetolog extends Model
{
    use HasFactory;

    protected $table = 'kosmetolog';

    protected $fillable = ['fio', 'specialnost', 'telefon'];

    // Один косметолог может проводить много сеансов
    public function seanss()
    {
        return $this->hasMany(Seans::class);
    }

}
