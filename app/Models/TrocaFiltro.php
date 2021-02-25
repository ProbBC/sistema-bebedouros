<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrocaFiltro extends Model
{
    use HasFactory;

    public function bebedouro(){
      return $this->belongsTo(Bebedouro::class);
    }

    public function user(){
      return $this->belongsTo(User::class);
    }

    public function solicitacaoTroca(){
      return $this->belongsTo(SolicitacaoTroca::class);
    }

    # troca o nome da variável padrão created_at
    const CREATED_AT = 'data';

    protected $fillable = [
      'solicitacao_troca_id',
      'comentarios',
    ];
}
