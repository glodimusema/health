<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo_entreprise extends Model
{
    //
    protected $fillable = [
        'id_entreprise', 'typeFichier','photo'
    ];
}
