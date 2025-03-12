<?php

namespace App\Models\Imagerie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tim_imagerie_ext extends Model
{
  
    protected $fillable=['id','refMouvement','refAnalyse','dateImagerie','clinique','but',
    'urgent','serviceProvenance','medecindemandeur',
    'medecinProtocolaire','specialiste','CNOM','examenDemande','status','author'];
    protected $table = 'tim_imagerie_ext'; 
}
