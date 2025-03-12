<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thospi_surveillance_hospie extends Model
{
    protected $fillable=['id','refHospi','medecinAssistant','author'];
    protected $table = 'thospi_surveillance_hospie';
}

