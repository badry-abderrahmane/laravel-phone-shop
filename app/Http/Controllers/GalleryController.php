<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

use \App\Gallery;

class GalleryController extends Controller
{

      /**
       * Create a new controller instance.
       *
       * @return void
       */
      public function __construct()
      {
          $this->middleware('auth');
      }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = Gallery::all();
        $galleries = $galleries->each(function ($item, $key) {
            $item->product;
        });
        return Response::json($galleries, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.galleries.manager');
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
          'name'  => 'required|min:3|unique:galleries',
          'link'  => 'required|min:4',
          'desc'  => '',
          'order' => 'integer',
          'product_id' => 'required|integer',
      ];

      $this->validate($request,$rules);

      Gallery::forceCreate([
        'name' => request('name'),
        'link'  => request('link'),
        'desc'  => request('desc'),
        'order' => request('order'),
        'product_id' => request('product_id')
      ]);

      return Response::json(['message' => 'Gallery inserted'], 200);
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
          'name'  => 'required|min:3|unique:galleries,name,'. $request->id,
          'link'  => 'required|min:4',
          'desc'  => '',
          'order' => 'integer',
          'product_id' => 'required|integer',
      ];

      $this->validate($request,$rules);

      $gallery = Gallery::findOrFail($id);

      $gallery->name = request('name');
      $gallery->link = request('link');
      $gallery->desc = request('desc');
      $gallery->order = request('order');
      $gallery->product_id = request('product_id');

      $gallery->save();

      return Response::json(['message' => 'Gallery well updated!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $var = Gallery::destroy($id);
      return Response::json($var, 200);
    }
}
