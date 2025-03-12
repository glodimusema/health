<?php

namespace App\Models\Consultations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdiagnosticdefinitif extends Model
{
    protected $fillable=['id','refdetailCons','refmaladie','descriptiondiagnostic','conclusion_maladie','author'];
    protected $table = 'tdiagnosticdefinitif';
}
