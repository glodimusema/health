<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
class CreatetcategorieclientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcategorieclient', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('designation');           
        });

        DB::table('tcategorieclient')->insert([
            ['designation' => 'PRIVE(E)'],
            ['designation' => 'ABONNE(E)'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tcategorie_client');
    }
}
