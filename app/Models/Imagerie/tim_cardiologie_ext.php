<?php

namespace App\Models\Imagerie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tim_cardiologie_ext extends Model
{
    protected $fillable=['id','refImagerie','indication','ventriculeGauche','ventriculeDroite',
    'oreillette', 'valve','oesophage','autres','conclusionCardio','imageCardio','author'];
    protected $table = 'tim_cardiologie_ext';
    
}
