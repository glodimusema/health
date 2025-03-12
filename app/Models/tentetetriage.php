<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tentetetriage extends Model
{
    protected $fillable=['id','refMouvement','dateTriage','author'];
    protected $table = 'tentetetriage';
}
