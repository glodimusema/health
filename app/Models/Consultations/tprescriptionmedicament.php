<?php

namespace App\Models\Consultations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tprescriptionmedicament extends Model
{
    protected $fillable=['id','refdetailCons','refmedicament','quantite','dosage','detailprescription','author'];
    protected $table = 'tprescriptionmedicament';
}
