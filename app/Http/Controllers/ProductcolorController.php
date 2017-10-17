<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

use \App\Product;
use \App\Productcolor;

class ProductcolorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.productcolors.manager');
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
            'name'  => 'required|min:3|unique:productcolors',
            'color_id' => 'integer',
            'product_id' => 'integer',
        ];

        $this->validate($request,$rules);

        Productcolor::forceCreate([
          'name' => request('name'),
          'color_id'  => request('color_id'),
          'product_id'  => request('product_id'),
        ]);

        return Response::json(['message' => 'Product color inserted'], 200);
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
      try {
          $product = Product::where('id',$id)->first();
          $product->productcolors->each(function($item,$key){
            $item->color;
          });
          return Response::json($product->productcolors, 200);
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
            'name'  => 'required|min:3|unique:productcolors,name,'. $request->id,
            'color_id' => 'integer',
            'product_id' => 'integer',
        ];

        $this->validate($request,$rules);

        $productcolor = Productcolor::findOrFail($id);

        $productcolor->name = request('name');
        $productcolor->color_id = request('color_id');
        $productcolor->product_id = request('product_id');

        $productcolor->save();

        return Response::json(['message' => 'Product color well updated!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $var = Productcolor::destroy($id);
      return Response::json($var, 200);
    }
}
