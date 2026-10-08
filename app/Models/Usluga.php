<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usluga extends Model
{
    use HasFactory;

    protected $table = 'usluga';

    protected $fillable = ['nazvanie', 'stoimost', 'prodolzhitelnost', 'image'];


    public function seans()
    {
        return $this->belongsToMany(Seans::class, 'okazannaya_usluga', 'usluga_id', 'seans_id');
    }

    public function kosmetologi()
    {
        return $this->belongsToMany(Kosmetolog::class, 'kosmetolog_usluga', 'usluga_id', 'kosmetolog_id');
    }

}
