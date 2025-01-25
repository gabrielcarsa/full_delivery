<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'customer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

     /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function customer_address()
    {
        return $this->hasMany(CustomerAddress::class);
    }
    
    public function pedido()
    {
        return $this->hasMany(Pedido::class);
    }

    public function uso_cupom()
    {
        return $this->belongsToMany(UsoCupom::class);
    }

    public function lancamento(){
        return $this->hasMany(Lancamento::class);
    }

}
