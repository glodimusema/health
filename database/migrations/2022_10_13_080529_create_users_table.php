<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('telephone', 250)->nullable();
            $table->string('adresse', 300)->nullable();
            $table->string('avatar', 300)->nullable();
            $table->string('sexe', 300)->nullable();
            $table->foreignId('id_role')->constrained('roles')->restrictOnUpdate()->restrictOnDelete();
            $table->integer('active')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            ['name' => 'Admin','email' => 'admin@gmail.com','password' => '$2y$10$sDi2.bCHlExaxEH5jSadEepldfXAoVe/RGtTv6/FrwVpmSABTIJ2y','id_role' => 1,'active' => 1],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
