<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

use \App\Serie;

class SerieController extends Controller
{

    public function __construct(){

        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $series = Serie::All();
        return Response::json($series, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.series.manager');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'name'  => 'required|min:3|unique:series',
            'code'  => 'required|min:2|unique:series',
            'desc'  => '',
            'order' => 'integer',
        ];

        $this->validate($request,$rules);

        Serie::forceCreate([
          'name' => request('name'),
          'code'  => request('code'),
          'desc'  => request('desc'),
          'order' => request('order')
        ]);

        return Response::json(['message' => 'Serie inserted'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $rules = [
          'name'  => 'required|min:3|unique:series,name,'. $request->id,
          'code'  => 'required|min:2|unique:series,code,'. $request->id,
          'order' => 'integer',
      ];

      $this->validate($request,$rules);

      $serie = Serie::findOrFail($id);

      $serie->name = request('name');
      $serie->code = request('code');
      $serie->desc = request('desc');
      $serie->order = request('order');
      $serie->state = request('state');

      $serie->save();

      return Response::json(['message' => 'Serie well updated!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $var = Serie::destroy($id);
        return Response::json($var, 200);
    }
}
