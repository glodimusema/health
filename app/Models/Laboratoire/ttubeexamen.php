<?php

namespace App\Models\Laboratoire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ttubeexamen extends Model
{
    protected $fillable=['id','codeTube','designationTube','couleurTube','author'];
    protected $table = 'ttubeexamen';
}
