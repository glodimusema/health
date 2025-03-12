<?php

namespace App\Models\Imagerie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tim_type_analyse extends Model
{
    protected $fillable=['id','nomTypeAnalyse'];
    protected $table = 'tim_type_analyse';
}
