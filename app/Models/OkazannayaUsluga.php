<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkazannayaUsluga extends Model
{
    use HasFactory;

    protected $table = 'okazannaya_usluga';

    protected $fillable = ['seans_id', 'usluga_id', 'kolichestvo', 'stoimost'];

    public function seans()
    {
        return $this->belongsTo(Seans::class, 'seans_id');
    }

    public function usluga()
    {
        return $this->belongsTo(Usluga::class, 'usluga_id');
    }
}
