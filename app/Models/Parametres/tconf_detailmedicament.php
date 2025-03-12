<?php

namespace App\Models\Parametres;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tconf_detailmedicament extends Model
{
    protected $fillable=['id','refmedicament','quantite','dateexpiration','dateEntree','author'];
    protected $table = 'tconf_detailmedicament';
}
