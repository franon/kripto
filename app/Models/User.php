<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'p_id',
        'p_namapengguna',
        'p_namalengkap',
        'email',
        'email_verified_at',
        'password',
        'peran_id',
        'is_active',
        'no_hp',
        'jen_kel',
        'remember_token',
    ];

    // protected $table = 'my_flights';
    protected $table = 'pengguna';
    protected $primaryKey = 'p_id';
    public $incrementing = false;
    protected $keyType  = 'string';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email',
        'email_verified_at',
        'peran_id',
        'is_active',
        'no_hp',
        'jen_kel',
        'created_at',
        'updated_at',
        'p_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function direktori(){
        return $this->hasMany(Direktori::class);
    }

    public function file(){
        return $this->hasMany(FileProcessing::class);
    }
}
