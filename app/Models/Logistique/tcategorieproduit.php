<?php

namespace App\Models\Logistique;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tcategorieproduit extends Model
{
    protected $fillable=['id','designation'];
    protected $table = 'tcategorieproduit';
}
