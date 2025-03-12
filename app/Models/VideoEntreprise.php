<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoEntreprise extends Model
{
    //
    protected $fillable = [
        'ceo','titre', 'description', 'url'
    ];
}
