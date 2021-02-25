<?php

namespace App\Http\Controllers;

use DB;
use App\Models\TrocaFiltro;
use App\Models\SolicitacaoTroca;
use Illuminate\Http\Request;

class TrocaFiltroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $trocaFiltros = TrocaFiltro::latest()->paginate(5);
      $solicitacaoTrocas = SolicitacaoTroca::all();

      return view('layouts.trocas', compact('trocaFiltros', 'solicitacaoTrocas'))
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
        'solicitacao_troca_id',
      ]);

      $solicitacao = SolicitacaoTroca::find($request->solicitacao_troca_id);

      if ($solicitacao->TrocaFiltro()->exists()){
        return redirect()->route('solicitacoes.index')
          ->with('error', 'Solicitação já atendida.');
      }

      $bebedouro_id = $solicitacao->bebedouro_id;

      $trocaFiltro = new TrocaFiltro();
      $trocaFiltro->bebedouro_id = $bebedouro_id;
      $trocaFiltro->user_id = $request->user()->id;
      $trocaFiltro->solicitacao_troca_id = $request->solicitacao_troca_id;
      $trocaFiltro->comentarios = $request->comentarios;

      # $solicitacao = SolicitacaoTroca::find($trocaFiltro->solicitacao_troca_id);
      $solicitacao->concluida = true;
      $solicitacao->save();

      $trocaFiltro->save();

      return redirect()->route('trocas.index')
        ->with('success', 'Troca realizada.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TrocaFiltro  $trocaFiltro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      /*$request->validate([
        'solicitacao_troca_id',
      ]);*/

      $trocaFiltro = TrocaFiltro::find($id);

      if ($request->input('comentarios') == NULL){
        $request['comentarios'] = $trocaFiltro->comentarios;
      }

      if ($request->input('solicitacao_troca_id') == NULL){
        $request['solicitacao_troca_id'] = $trocaFiltro->solicitacao_troca_id;

        $trocaFiltro->update($request->all());

      }else{
        print(var_dump($trocaFiltro->solicitacao_troca_id));
        $old_solicitacao = SolicitacaoTroca::find($trocaFiltro->solicitacao_troca_id);
        $old_solicitacao->concluida = FALSE;

        $new_solicitacao = SolicitacaoTroca::find($request['solicitacao_troca_id']);
        $new_solicitacao->concluida = TRUE;

        try {
          DB::connection('mysql')->beginTransaction();
          $old_solicitacao->save();
          $new_solicitacao->save();
          $trocaFiltro->update($request->all());
          $trocaFiltro->bebedouro_id = $new_solicitacao->bebedouro_id;
          $trocaFiltro->save();
          DB::connection('mysql')->commit();
        } catch (\PDOException $e) {
          DB::connection('mysql')->rollBack();
        }
      }



      return redirect()->route('trocas.index')
        ->with('success', 'Troca alterada.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrocaFiltro  $trocaFiltro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      try {
        DB::connection('mysql')->beginTransaction();
        $trocaFiltro = TrocaFiltro::find($request->input('troca_filtro_id'));
        error_log($trocaFiltro);
        $solicitacao = SolicitacaoTroca::find($trocaFiltro->solicitacao_troca_id);
        $solicitacao->concluida = FALSE;
        $solicitacao->save();
        $trocaFiltro->delete();
        DB::connection('mysql')->commit();
      } catch (\PDOException $e) {
        DB::connection('mysql')->rollBack();
      }

      return redirect()->route('trocas.index')
        ->with('success', 'Troca removida.');
    }
}
