<?php

namespace App\Models\Imagerie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tim_imagerie extends Model
{
  
    protected $fillable=['id','refDetailConst','refAnalyse','dateImagerie','clinique','but',
    'urgent','serviceProvenance','medecindemandeur',
    'medecinProtocolaire','specialiste','CNOM','examenDemande','status','author'];
    protected $table = 'tim_imagerie'; 
}
