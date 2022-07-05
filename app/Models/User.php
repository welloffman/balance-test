<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function balance()
    {
        return $this->hasOne(Balance::class)->first();
    }

    public function operations()
    {
        return $this->hasMany(Operation::class)->get();
    }

    public function getBalance()
    {
        $balance = $this->balance();

        if(!$balance) {
            $balance = $this->makeBalance();
        }

        return $balance;
    }

    public function getOperations($limit = null)
    {
        if($limit) {
            $operations = Operation::where('user_id', $this->id)->orderByDesc('created_at')->limit($limit)->get();
        } else {
            $operations = Operation::where('user_id', $this->id)->orderByDesc('created_at')->get();
        }
          
        return $operations;
    }

    public function makeBalance()
    {
        $balance = new Balance();
        $balance->user_id = $this->id;
        $balance->amount = 0;
        return $balance;
    }
}
