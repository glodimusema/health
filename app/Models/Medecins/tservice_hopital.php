<?php

namespace App\Models\Medecins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tservice_hopital extends Model
{
    protected $fillable=['id','nom_service'];
    protected $table = 'tservice_hopital';
}
