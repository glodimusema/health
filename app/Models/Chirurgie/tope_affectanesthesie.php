<?php

namespace App\Models\Chirurgie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tope_affectanesthesie extends Model
{
    protected $fillable=[
    'id','refEnteteAnesthesie','refTypeAnesthesie','detail_affectAnesthesie','author'];
    protected $table = 'tope_affectanesthesie';

             

            
}
