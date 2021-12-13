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
            $table->uuid('uid')->unique();
            $table->string('name', 255);
            $table->string('cpf', 11)->unique();
            $table->date('birthday');
            $table->string('mother', 255);
            $table->string('email', 255)->unique();
            $table->string('phone', 11);
            $table->string('zipcode', 8);
            $table->string('state', 255);
            $table->string('city', 255);
            $table->string('district', 255);
            $table->string('address', 255);
            $table->string('number', 255);
            $table->string('logradouro', 255)->nullable();
            $table->string('complement', 255)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
