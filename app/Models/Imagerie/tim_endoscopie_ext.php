<?php

namespace App\Models\Imagerie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tim_endoscopie_ext extends Model
{
    protected $fillable=['id','refImagerie','descriptionEndo','conclusionEndo','imageEndo','author'];
    protected $table = 'tim_endoscopie_ext';
    
}
