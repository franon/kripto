<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FileProcessing extends Model
{
    use HasFactory;

    protected $table = 'file';
    protected $primaryKey = 'file_id';
    public $incrementing = false;
    protected $keyType  = 'string';
    protected $guarded = [];
    public $timestamps = false;

    // protected $fillable= [
    //     'file_id',
    //     'file_nama',
    //     'file_tipe',
    //     'file_jalur',
    //     'file_jalurutuh',
    //     'file_ukuran',
    //     'p_id',
    //     'pembuat',
    //     'tanggal_buat',
    //     'dir_id',
    //     'dir_nama',
    //     // 'pinet_id',
    //     'tagihan_id',
    //     // 'k_id'
    // ];

    public function direktori(){
        return $this->belongsTo(Direktori::class,'dir_id');
        // return dd($this->belongsTo(Direktori::class,'dir_id'));
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
