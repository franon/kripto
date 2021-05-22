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
            $table->string('u_id');
            $table->string('u_username')->unique();
            $table->string('u_fullname')->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyText('role_id')->nullable();
            $table->tinyText('is_active')->nullable();
            $table->string('phone_number')->nullable();
            $table->tinyText('gender')->nullable();
            $table->rememberToken()->nullable();
            $table->timestamps();
            $table->primary('u_id');
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
