<?php

namespace App\Models\Imagerie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tim_analyse extends Model
{
    protected $fillable=['id','nomAnalyse','prix','prixConvention','codeAnalyse','ReftypeAnalyse'];
    protected $table = 'tim_analyse';
    
 
}
