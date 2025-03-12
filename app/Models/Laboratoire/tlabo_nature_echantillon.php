<?php

namespace App\Models\Laboratoire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tlabo_nature_echantillon extends Model
{
    protected $fillable=['id','designation_nature','designation_valeur','refCategorieEchantillon','author'];
    protected $table = 'tlabo_nature_echantillon';
}
