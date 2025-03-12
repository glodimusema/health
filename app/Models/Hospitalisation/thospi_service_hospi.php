<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thospi_service_hospi extends Model
{
    protected $fillable=['id','nomServiceHospi'];
    protected $table = 'thospi_service_hospi';
}