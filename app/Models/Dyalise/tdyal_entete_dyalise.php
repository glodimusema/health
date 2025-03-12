<?php

namespace App\Models\Dyalise;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdyal_entete_dyalise extends Model
{
    protected $fillable=['id','dateDemande','refDetailConst','auther'];
    protected $table = 'tdyal_entete_dyalise';
    
}
