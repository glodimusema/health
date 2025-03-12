<?php

namespace App\Models\Chirurgie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tope_typeanesthesie extends Model
{
    protected $fillable=[
    'id',
    'nom_tyepeanesthesie',
    'prix_typeanesthesie',   
    'aurhor'
    ];
    protected $table = 'tope_typeanesthesie';

    
}
