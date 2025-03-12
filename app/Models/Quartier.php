<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quartier extends Model
{
    //
    protected $fillable = [
        'idCommune', 'nomQuartier' 
    ];
}
