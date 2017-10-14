<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

use \App\Optiongroup;

class OptiongroupController extends Controller
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
      $optiongroups = Optiongroup::All();
      $optiongroups = $optiongroups->each(function($item,$key){
        $item->category;
      });
      return Response::json($optiongroups, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.optiongroups.manager');
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
          'name'  => 'required|min:3|unique:optiongroups',
          'order' => 'integer',
          'category_id' => 'integer',
      ];

      $this->validate($request,$rules);

      Optiongroup::forceCreate([
        'name' => request('name'),
        'desc'  => request('desc'),
        'order' => request('order'),
        'category_id'  => request('category_id')
      ]);

      return Response::json(['message' => 'Option group inserted'], 200);
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
            'name'  => 'required|min:3|unique:optiongroups,name,'. $request->id,
            'order' => 'integer',
            'category_id' => 'integer',
        ];

        $this->validate($request,$rules);

        $optiongroup = Optiongroup::findOrFail($id);

        $optiongroup->name = request('name');
        $optiongroup->desc = request('desc');
        $optiongroup->order = request('order');
        $optiongroup->category_id = request('category_id');

        $optiongroup->save();

        return Response::json(['message' => 'Option group well updated!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $var = Optiongroup::destroy($id);
      return Response::json($var, 200);
    }
}
