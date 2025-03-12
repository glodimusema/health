<?php

namespace App\Models\Laboratoire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tgcategorieexament extends Model
{
    protected $fillable=['id','designation'];
    protected $table = 'tgcategorieexament';
}
