<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenggunaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->string('p_id');
            $table->string('p_namapengguna')->unique();
            $table->string('p_namalengkap')->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyText('peran_id')->nullable();
            $table->tinyText('is_active')->nullable();
            $table->string('no_hp')->nullable();
            $table->tinyText('jen_kel')->nullable();
            $table->rememberToken()->nullable();
            $table->timestamps();
            $table->primary('p_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengguna');
    }
}
