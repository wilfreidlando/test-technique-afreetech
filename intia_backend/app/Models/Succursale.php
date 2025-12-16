<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Succursale extends Model
{
    /** @use HasFactory<\Database\Factories\SuccursaleFactory> */
    use HasFactory;
  protected $fillable = [
        'nom',
        'ville',
        'adresse',
        'telephone',
        'email',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}
