<?php
namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thospi_actesmdecin extends Model
{
    protected $fillable=['id','refHospi','observation','author'];
    protected $table = 'thospi_actesmdecin';
}


