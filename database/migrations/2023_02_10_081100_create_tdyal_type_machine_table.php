<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdyalTypeMachineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdyal_type_machine', function (Blueprint $table) {
            $table->id();
            $table->string('nomTypeMachine',100);
            $table->string('description',100);
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tdyal_type_machine')->insert([
            ['nomTypeMachine' => 'Machine 5000','description' => 'Machine 5000'],
            ['nomTypeMachine' => 'Machine 4000','description' => 'Machine 4000'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tdyal_type_machine');
    }
}
