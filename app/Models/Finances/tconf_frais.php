<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tconf_frais extends Model
{
    protected $fillable=['id','designation'];
    protected $table = 'tconf_frais';
}
