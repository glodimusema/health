<?php

namespace App\Models\Chirurgie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tope_enteteoperation extends Model
{
    protected $fillable=[
    'id','refDetailCons','dateeneteop','author'
];
    protected $table = 'tope_enteteoperation';

            
}
