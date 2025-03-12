<?php

namespace App\Models\Chirurgie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tope_departement extends Model
{
    protected $fillable=['id','nom_departement'];
    protected $table = 'tope_departement';
}
