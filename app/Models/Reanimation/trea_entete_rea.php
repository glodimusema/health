<?php

namespace App\Models\Reanimation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trea_entete_rea extends Model
{

    protected $fillable=['id','refDetailConst','auther'];
    protected $table = 'trea_entete_rea';
}
