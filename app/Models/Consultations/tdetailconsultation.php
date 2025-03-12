<?php

namespace App\Models\Consultations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdetailconsultation extends Model
{
    protected $fillable=['id','refEnteteCons','refTypeCons','PrixCons','plainte','historique','antecedent','complementanamnese',
    'examenphysique','diagnostiquePres','dateDetailCons','AutresDiagnostics','author','created_at','updated_at'];
    protected $table = 'tdetailconsultation';
}
