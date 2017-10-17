<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use \App\Product;
use \App\Productoption;

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
        $rules = [
            'value'  => 'required|min:2',
            'option_id' => 'integer',
            'product_id' => 'integer',
        ];

        $this->validate($request,$rules);

        Productoption::forceCreate([
          'value' => request('value'),
          'option_id'  => request('option_id'),
          'product_id'  => request('product_id'),
        ]);

        return Response::json(['message' => 'Product option inserted'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.productoptions.manager',['product_id' => $id]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      try {
          $product = Product::where('id',$id)->first();
          $product->productoptions->each(function($item,$key){
            $item->option->optiongroup;
          });
          return Response::json($product->productoptions, 200);
      } catch(QueryException $e) {
          return Response::json($e);
      }
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
          'value'  => 'required|min:2',
          'option_id' => 'integer',
          'product_id' => 'integer',
      ];

      $this->validate($request,$rules);

      $productoption = Productoption::findOrFail($id);

      $productoption->value = request('value');
      $productoption->option_id = request('option_id');
      $productoption->product_id = request('product_id');

      $productoption->save();

      return Response::json(['message' => 'Product option well updated!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $var = Productoption::destroy($id);
      return Response::json($var, 200);
    }
}
