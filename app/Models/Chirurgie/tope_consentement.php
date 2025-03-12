<?php

namespace App\Models\Chirurgie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tope_consentement extends Model
{
    protected $fillable=[
    'id','refEnteteOpe','dateConsentement','chirurgien','anesthesiste','intervention',
    'prevision','actechirurgie','author'];
    protected $table = 'tope_consentement';

            
}
