<?php

namespace App\Http\Controllers;

use App\Models\Bebedouro;
use App\Models\Bloco;
use Illuminate\Http\Request;

class BebedouroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $bebedouros = Bebedouro::latest()->paginate(5);
      $blocos = Bloco::all();

      return view('layouts.bebedouros', compact('bebedouros', 'blocos'))
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
        'bloco_id' => 'required',
        'desc' => 'required'
      ]);

      bebedouro::create($request->all());

      return redirect()->route('bebedouros.index')
        ->with('success', 'Bebedouro criado.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bebedouro  $bebedouro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bebedouro $bebedouro)
    {
      /*$request->validate([
        'bloco_id' => 'required',
        'desc' => 'required'
      ]);*/
      if ($request->input('desc') == NULL){
        $request['desc'] = $bebedouro->desc;
      }

      if ($request->input('bloco_id') == NULL){
        $request['bloco_id'] = $bebedouro->bloco_id;
      }

      $bebedouro->update($request->all());

      return redirect()->route('bebedouros.index')
        ->with('success', 'Bebedouro alterado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bebedouro  $bebedouro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $bebedouroId = $request->input('bebedouro_id');
      $bebedouro = Bebedouro::where('id', $bebedouroId);
      $bebedouro->delete();

      return redirect()->route('bebedouros.index')
        ->with('success', 'Bebedouro removido.');
    }
}
