<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan_Klien extends Model
{
    use HasFactory;

    protected $table = 'tagihan_klien';
    protected $primaryKey = 'tagihan_id';
    protected $guarded = [];
    public $timestamps = false;
}
