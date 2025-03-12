<?php

namespace App\Models\Chirurgie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tope_detailanesthesie extends Model
{
    protected $fillable=
    [
    'id',
    'refAnesthesie',   
    'refTypeAnesthesie',
    'detail_affectAnesthesie',
    'author'
    ];
    protected $table = 'tope_detailanesthesie';

            
}
