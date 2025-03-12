<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmedDetailUsageserviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmed_detail_usageservice', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteVente')->constrained('tmouvement')->restrictOnUpdate()->restrictOnDelete();  
            $table->foreignId('refmedicament')->constrained('tconf_medicament')->restrictOnUpdate()->restrictOnDelete();
            $table->double('qte_usage');
            $table->double('pu_usage');
            $table->string('observation_usage');
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tmed_detail_usageservice');
    }
}
