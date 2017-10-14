<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

use \App\Color;

class ColorController extends Controller
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
      $colors = Color::All();
      return Response::json($colors, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.colors.manager');
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
            'name'  => 'required|min:3|unique:colors',
            'code'  => 'required|min:2|unique:colors',
        ];

        $this->validate($request,$rules);

        Color::forceCreate([
          'name' => request('name'),
          'code'  => request('code'),
        ]);

        return Response::json(['message' => 'Color inserted'], 200);
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
            'name'  => 'required|min:3|unique:colors,name,'. $request->id,
            'code'  => 'required|min:2|unique:colors,code,'. $request->id,
        ];

        $this->validate($request,$rules);

        $color = Color::findOrFail($id);

        $color->name = request('name');
        $color->code = request('code');

        $color->save();

        return Response::json(['message' => 'Color well updated!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $var = Color::destroy($id);
      return Response::json($var, 200);
    }
}
