<?php

namespace App\Http\Controllers;

use App\Models\SolicitacaoTroca;
use App\Models\Bebedouro;
use Illuminate\Http\Request;

class SolicitacaoTrocaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $solicitacaoTrocas = SolicitacaoTroca::latest()->paginate(5);
      $bebedouros = Bebedouro::all();

      return view('layouts.solicitacoes', compact('solicitacaoTrocas', 'bebedouros'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
        'bebedouro_id',
        'motivo',
      ]);

      $request->user()->solicitacaoTrocas()->create($request->all());

      return redirect()->route('solicitacoes.index')
        ->with('success', 'Solicitação criada.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SolicitacaoTroca  $solicitacaoTroca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SolicitacaoTroca $solicitacaoTroca)
    {
      /*
      $request->validate([
        'bebedouro_id',
        'motivo',
      ]);*/
      if ($request->input('motivo') == NULL){
        $request['motivo'] = $solicitacaoTroca->motivo;
      }

      if ($request->input('bebedouro_id') == NULL){
        $request['bebedouro_id'] = $solicitacaoTroca->bebedouro_id;
      }

      $solicitacaoTroca->update($request->all());

      return redirect()->route('solicitacoes.index')
        ->with('success', 'Solicitação alterada.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SolicitacaoTroca  $solicitacaoTroca
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $solicitacaoId = $request->input('solicitacao_troca_id');
      $solicitacao = SolicitacaoTroca::where('id', $solicitacaoId);
      $solicitacao->delete();

      return redirect()->route('solicitacoes.index')
        ->with('success', 'Solicitação removida.');
    }
}
