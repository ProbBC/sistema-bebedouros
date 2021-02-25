<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bloco extends Model
{
    use HasFactory;

    public function bebedouros(){
      return $this->hasMany(Bebedouro::class);
    }

    protected $fillable = [
      'desc'
    ];
}
