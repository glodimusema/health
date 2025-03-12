<?php

namespace App\Models\Chirurgie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tope_acteoperatoire extends Model
{
    protected $fillable=['id','nom_acteop','prix_acteop','aurhor'];
    protected $table = 'tope_acteoperatoire';

    
}
