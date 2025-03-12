<?php

namespace App\Models\Consultations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_resumeclinique extends Model
{
    protected $fillable=['id','refDetailCons','detailresume','plainte_resumes','examenphysiques','appreciations','suggestions','Intervenants','author'];
    protected $table = 'tfin_resumeclinique';
}
