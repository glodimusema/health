<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ttypemouvement_malade extends Model
{
    protected $fillable=['id','designation'];
    protected $table = 'ttypemouvement_malade';
}
