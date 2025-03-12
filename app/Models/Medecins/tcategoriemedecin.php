<?php

namespace App\Models\Medecins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tcategoriemedecin extends Model
{
    protected $fillable=['id','designation'];
    protected $table = 'tcategoriemedecin';
}
