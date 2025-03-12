<?php

namespace App\Models\Chirurgie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tope_intervention extends Model
{
    protected $fillable=['id','nom_intervention'];
    protected $table = 'tope_intervention';
}
