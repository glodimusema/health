<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTneroTypeRapportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tnero_type_rapport', function (Blueprint $table) {
            $table->id();
            $table->string('name_typeRapport',100);
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tnero_type_rapport')->insert([
            ['name_typeRapport' => 'RAPPORT MEDICAL NEUROLOGIE'],
            ['name_typeRapport' => 'ATTESTATION MEDICALE NEUROLOGIE']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tnero_type_rapport');
    }
}
