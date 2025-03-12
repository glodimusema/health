<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tlit extends Model
{
    protected $fillable=['id','nom_lit','refSalle'];
    protected $table = 'tlit';
}
