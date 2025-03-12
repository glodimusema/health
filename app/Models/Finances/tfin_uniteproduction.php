<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_uniteproduction extends Model
{
    protected $fillable=['id','refDepartement','nom_uniteproduction',
    'code_uniteproduction','author'];
    protected $table = 'tfin_uniteproduction';  
}
