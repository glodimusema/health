<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
class CreatetcategorieproduitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcategorieproduit', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('designation');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user');  
        });

        DB::table('tcategorieproduit')->insert([
            ['designation' => 'DOCUMENTS'],
            ['designation' => 'OUTILS DE BUREAU'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tcategorieproduit');
    }
}
