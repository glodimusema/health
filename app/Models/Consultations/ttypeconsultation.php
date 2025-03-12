<?php

namespace App\Models\Consultations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ttypeconsultation extends Model
{
    protected $fillable=['id','designation','PrixCons','created_at','updated_at'];
    protected $table = 'ttypeconsultation';
}
