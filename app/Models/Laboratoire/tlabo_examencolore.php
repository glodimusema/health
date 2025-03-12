<?php

namespace App\Models\Laboratoire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tlabo_examencolore extends Model
{
    protected $fillable=['id','nom_examencolore','author'];
    protected $table = 'tlabo_examencolore';
}
