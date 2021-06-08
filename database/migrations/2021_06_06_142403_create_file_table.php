<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file', function (Blueprint $table) {
            $table->string('file_id');
            $table->string('file_nama');
            $table->string('file_alias');
            $table->string('file_tipe',10)->nullable();
            $table->string('file_jalur')->nullable();
            $table->string('file_jalurutuh')->nullable();
            $table->integer('file_ukuran')->nullable();
            $table->string('p_id')->nullable();
            $table->string('pembuat')->nullable();
            $table->date('tanggal_buat')->nullable();
            $table->string('dir_id')->nullable();
            $table->string('dir_nama')->nullable();
            $table->unsignedBigInteger('tagihan_id')->nullable();
            // $table->string('pinet_id')->nullable();
            // $table->string('k_id')->nullable();

            $table->primary('file_id');

            $table->index(['p_id','dir_id','tagihan_id']);

            $table->foreign('p_id')->nullable()->references('p_id')->on('pengguna')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('dir_id')->nullable()->references('dir_id')->on('direktori')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('pinet_id')->nullable()->references('pinet_id')->on('paket_internet')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tagihan_id')->nullable()->references('tagihan_id')->on('tagihan_klien')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('k_id')->nullable()->references('k_id')->on('klien')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file');
    }
}
