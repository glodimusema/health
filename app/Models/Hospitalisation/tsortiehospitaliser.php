<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tsortiehospitaliser extends Model
{
    protected $fillable=['id','refHospitaliser','dateSortie','diagnosticSortie','autreDetails',
    "medecin1","specialite1","cnom1","medecin2","specialite2","cnom2","medecin3","specialite3",
    "cnom3","dateRDV","heureSortieHosp",'author'];
    protected $table = 'tsortiehospitaliser';
}
