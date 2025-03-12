<?php

namespace App\Models\Laboratoire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tcategorieexamen extends Model
{
    protected $fillable=['id','designation','refGrandCategorie'];
    protected $table = 'tcategorieexament';
}
