<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatetmedecinTable extends Migration
{
    /**
     * Run the migrations.
     *photoslug
     * @return void
     */
    public function up()
    {
        Schema::create('tmedecin', function (Blueprint $table) {
            $table->id();
            $table->string('matricule_medecin');
            $table->string('noms_medecin');
            $table->string('sexe_medecin'); 
            $table->date('datenaissance_medecin'); 
            $table->string('lieunaissnce_medecin');
            $table->string('provinceOrigine_medecin');           
            $table->string('etatcivil_medecin');
            $table->foreignId('refAvenue_medecin')->constrained('avenues')->restrictOnUpdate()->restrictOnDelete();
            $table->string('contact_medecin'); 
            $table->string('mail_medecin');
            $table->string('grade_medecin');
            $table->string('fonction_medecin');
            $table->string('specialite_medecin');
            $table->string('Categorie_medecin');
            $table->string('niveauEtude_medecin');           
            $table->string('anneeFinEtude_medecin');
            $table->string('Ecole_medecin'); 
            $table->string('photo'); 
            $table->string('slug'); 
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user');    
            $table->timestamps();                  
        });


        DB::table('tmedecin')->insert([
            ['matricule_medecin' => '000001','noms_medecin' => 'MEDECIN1',
            'sexe_medecin' => 'Homme','datenaissance_medecin' => '1996-12-25','lieunaissnce_medecin' => 'GOMA',
            'provinceOrigine_medecin' => 'BUKAVU','etatcivil_medecin' => 'Marié(e)','refAvenue_medecin' => 1,
            'contact_medecin' => '+243992992063','mail_medecin' => 'medecin@gmail.com','grade_medecin' => 'MEDECIN',
            'fonction_medecin' => 'CONSULTATION','specialite_medecin' => 'MEDECIN','Categorie_medecin' => 'INTERNE',
            'niveauEtude_medecin' => 'Licence','anneeFinEtude_medecin' => '2015','Ecole_medecin' => 'UOB',
            'photo' => 'avatar.png','slug' => '0000000','author' => 'Admin'],
        ]);



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tmedecin');
    }
}
