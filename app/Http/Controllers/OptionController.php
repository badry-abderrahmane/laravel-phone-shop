<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

use \App\Option;;

class OptionController extends Controller
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
      $options = Option::All();
      $options = $options->each(function($item,$key){
        $item->optiongroup;
      });
      return Response::json($options, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.options.manager');
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
            'name'  => 'required|min:2',
            'order' => 'required',
            'optiongroup_id' => 'required',
        ];

        $this->validate($request,$rules);

        Option::forceCreate([
          'name' => request('name'),
          'order' => request('order'),
          'desc'  => request('desc'),
          'optiongroup_id'  => request('optiongroup_id'),
        ]);

        return Response::json(['message' => 'Option inserted'], 200);
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
        'name'  => 'required|min:2',
        'order' => 'required',
        'optiongroup_id' => 'required',
      ];

      $this->validate($request,$rules);

      $option = Option::findOrFail($id);

      $option->name = request('name');
      $option->desc = request('desc');
      $option->order = request('order');
      $option->optiongroup_id = request('optiongroup_id');

      $option->save();

      return Response::json(['message' => 'Option well updated!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $var = Option::destroy($id);
      return Response::json($var, 200);
    }
}
