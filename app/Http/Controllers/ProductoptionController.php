<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use \App\Product;

class ProductoptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $relations = ['category', 'serie','accessories','galleries','productoptions','productcolors'];
      try {
          $product = Product::with($relations)->where('id','2')->first();
          $product->productoptions->each(function($item,$key){
            $item->option->optiongroup;
          });
          $product->productcolors->each(function($item,$key){
            $item->color;
          });

          return Response::json($product, 200);
      } catch(ModelNotFoundException $e) {
          return Redirect::action('ProductController@create');
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.productoptions.manager');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $relations = ['category', 'serie','accessories','galleries'];
        try {
            $product = Product::with($relations)->where('id',$id)->first();
            $product->productoptions->each(function($item,$key){
              $item->option->optiongroup;
            });
            $product->productcolors->each(function($item,$key){
              $item->color;
            });
            return view('admin.productoptions.manager',['product' => $product]);
        } catch(ModelNotFoundException $e) {
            return Redirect::action('ProductController@create');
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
