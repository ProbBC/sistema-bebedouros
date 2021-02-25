<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitacaoTroca extends Model
{
    use HasFactory;

    public function bebedouro(){
      return $this->belongsTo(Bebedouro::class);
    }

    public function user(){
      return $this->belongsTo(User::class);
    }

    public function trocaFiltro(){
      return $this->hasOne(TrocaFiltro::class);
    }

    # troca o nome da variável padrão created_at
    const CREATED_AT = 'data';

    protected $fillable = [
      'bebedouro_id',
      'motivo'
    ];

}
