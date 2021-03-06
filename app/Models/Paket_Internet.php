<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket_Internet extends Model
{
    use HasFactory;

    protected $table = 'paket_internet';
    protected $primaryKey = 'pinet_id';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType  = 'string';
    public $timestamps = false;

    public function klien(){
        return $this->belongsToMany(Klien::class,'paket_klien','pinet_id','k_id')->withPivot('pk_no','pk_harga');
    }
}
