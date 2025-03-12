<?php

namespace App\Models\Laboratoire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tconf_methodeexamen extends Model
{
    protected $fillable=['id','designation'];
    protected $table = 'tconf_methodeexamen';
}
