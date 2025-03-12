<?php

namespace App\Models\Medecins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfonctionmedecin extends Model
{
    protected $fillable=['id','designation'];
    protected $table = 'tfonctionmedecin';
}
