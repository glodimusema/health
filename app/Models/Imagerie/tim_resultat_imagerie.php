<?php

namespace App\Models\Imagerie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tim_resultat_imagerie extends Model
{
  
    protected $fillable=['id','refImagerie','technique_res','description_res','conclusion_res','image_res','author'];
    protected $table = 'tim_resultat_imagerie'; 
}
