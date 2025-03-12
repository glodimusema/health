<?php

namespace App\Models\Chirurgie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tope_detailevaluation extends Model
{
    protected $fillable=[
    'id','refEnteteEva','jour','dateDetailEva','heure','TA','Pouls', 'Dieurese','Conscience',
    'Evolution','author'];
    protected $table = 'tope_detailevaluation';

            
}
