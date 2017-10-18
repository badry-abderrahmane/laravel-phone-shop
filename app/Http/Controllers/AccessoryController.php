<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

use \App\Accessory;

class AccessoryController extends Controller
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
        $accessories = Accessory::All();
        $accessories = $accessories->each(function($item,$key){
          $item->category;
        });
        return Response::json($accessories, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.accessories.manager');
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
          'name'  => 'required|min:3|unique:accessories',
          'category_id' => 'integer',
      ];

      $this->validate($request,$rules);

      Accessory::forceCreate([
        'name' => request('name'),
        'link'  => request('link'),
        'imgs'  => request('imgs'),
        'desc'  => request('desc'),
        'category_id' => request('category_id')
      ]);

      return Response::json(['message' => 'Accessory inserted'], 200);
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
          'name'  => 'required|min:3|unique:accessories,name,'. $request->id,
          'category_id' => 'integer',
      ];

      $this->validate($request,$rules);

      $accessory = Accessory::findOrFail($id);

      $accessory->name = request('name');
      $accessory->link = request('link');
      $accessory->imgs = request('imgs');
      $accessory->desc = request('desc');
      $accessory->category_id = request('category_id');

      $accessory->save();

      return Response::json(['message' => 'Accessory well updated!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $var = Accessory::destroy($id);
      return Response::json($var, 200);
    }
}
