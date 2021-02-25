<?php

namespace App\Http\Controllers;

use App\Models\Bloco;
use Illuminate\Http\Request;

class BlocoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $blocos = Bloco::latest()->paginate(5);

      return view('layouts.blocos', compact('blocos'))
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
        'desc' => 'required'
      ]);

      Bloco::create($request->all());

      return redirect()->route('blocos.index')
        ->with('success', 'Bloco criado.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bloco  $bloco
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bloco $bloco)
    {
      $request->validate([
        'desc' => 'required'
      ]);

      $bloco->update($request->all());

      return redirect()->route('blocos.index')
        ->with('success', 'Bloco alterado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bloco  $bloco
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $bloco_id = $request->input('bloco_id');
      $bloco = Bloco::where('id', $bloco_id);
      $bloco->delete();

      return redirect()->route('blocos.index')
        ->with('success', 'Bloco removido.');
    }
}
