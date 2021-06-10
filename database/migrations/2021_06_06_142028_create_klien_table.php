<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKlienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('klien', function (Blueprint $table) {
            // $table->string('k_id');
            $table->increments('k_id');
            $table->string('k_namapengguna');
            $table->string('k_namalengkap');
            $table->string('k_email')->nullable();
            $table->string('k_password');
            $table->string('k_alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->date('mulai_berlangganan');
            $table->string('no_kontrak')->nullable();
            // $table->primary('k_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('klien');
    }
}
