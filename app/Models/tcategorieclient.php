<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tcategorieclient extends Model
{
    protected $fillable=['id','designation'];
    protected $table = 'tcategorieclient';
}
