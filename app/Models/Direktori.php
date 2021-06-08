<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direktori extends Model
{
    use HasFactory;

    protected $table = 'direktori';
    protected $primaryKey = 'dir_id';
    public $incrementing = false;
    protected $keyType  = 'string';
    protected $guarded = [];

    // protected $fillable= [
    //     'dir_id',
    //     'dir_nama',
    //     'dir_jalur',
    //     'pembuat',
    //     'tanggal_buat',
    //     'p_id',
    // ];

    public function file(){
        return $this->hasMany(FileProcessing::class,'dir_id');
        // return dd($this->hasMany(FileProcessing::class,'dir_id'));
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
