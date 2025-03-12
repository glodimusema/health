<?php

namespace App\Models\Pharmacie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tmed_detail_sortie extends Model
{
    protected $fillable=['id','refEnteteSortie','refDetailMed','puSortie','qteSortie','author'];
    protected $table = 'tmed_detail_sortie';
}
