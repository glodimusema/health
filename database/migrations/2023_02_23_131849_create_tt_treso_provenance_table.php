<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtTresoProvenanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tt_treso_provenance', function (Blueprint $table) {
            $table->id();
            $table->string('nomProvenance');
            $table->string('codeProvenance');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tt_treso_provenance')->insert([
            ['nomProvenance' => 'SERVICE TECHINIQUE', 'codeProvenance' => 'STEC'],
            ['nomProvenance' => 'TRESORERIE','codeProvenance' => 'TRES'],
            ['nomProvenance' => 'LOGISTIQUE','codeProvenance' => 'LOG']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tt_treso_provenance');
    }
}
