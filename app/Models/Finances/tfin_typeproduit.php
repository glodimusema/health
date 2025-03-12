<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_typeproduit extends Model
{
    protected $fillable=['id','nom_typeproduit','author'];
    protected $table = 'tfin_typeproduit';

}
