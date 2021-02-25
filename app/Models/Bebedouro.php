<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bebedouro extends Model
{
    use HasFactory;

    public function bloco(){
      return $this->belongsTo(Bloco::class);
    }

    public function solicitacaoTrocas(){
      return $this->hasMany(SolicitacaoTroca::class);
    }

    public function trocaFiltros(){
      return $this->hasMany(TrocaFiltro::class);
    }

    protected $fillable = [
      'bloco_id',
      'desc'
    ];
}
