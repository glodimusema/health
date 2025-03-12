<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affectations extends Model
{
    protected $fillable=['id','refClient','refPersonne','Date'];
    protected $table = 'affectations';
}
