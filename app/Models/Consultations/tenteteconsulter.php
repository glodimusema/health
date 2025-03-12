<?php

namespace App\Models\Consultations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tenteteconsulter extends Model
{
    protected $fillable=['id','refDetailTriage','refMedecin','TypeOrientation','dateConsultation','statutentetecons','author','cloture','refLitUrgence','finUrgence','created_at','updated_at'];
    protected $table = 'tenteteconsulter';
}
//tenteteconsulter