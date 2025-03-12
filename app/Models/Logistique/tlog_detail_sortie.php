<?php

namespace App\Models\Logistique;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tlog_detail_sortie extends Model
{
    protected $fillable=['id','refEnteteSortie','refProduit','puSortie','qteSortie','author'];
    protected $table = 'tlog_detail_sortie';
}
