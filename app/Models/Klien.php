<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klien extends Model
{
    use HasFactory;

    protected $table = 'klien';
    protected $primaryKey = 'k_id';
    protected $guarded = [];

    public function paket_internet(){
        return $this->belongsToMany(Paket_Internet::class,'paket_klien','k_id','pinet_id');
    }
}
