<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tsalle extends Model
{
    protected $fillable=['id','nom_salle','PrixSalle'];
    protected $table = 'tsalle';
}
