<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

use \App\Product;

class ProductController extends Controller
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
        $products = Product::all();

        $products->filter->category;
        $products->filter->serie;
        $products->filter->productcolors;
        $products->filter->productoptions;

        return Response::json($products, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.manager');
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
            'name'  => 'required|min:3|unique:products',
            'serie_id'  => 'required',
            'category_id'  => 'required',
            'order' => 'integer',
        ];

        $this->validate($request,$rules);

        Product::forceCreate([
          'name'=> request('name'),
          'shortDesc'=> request('shortDesc'),
          'longDesc'=> request('longDesc'),
          'imgs'=> request('imgs'),
          'links'=> request('links'),
          'tags'=> request('tags'),
          'order'=> request('order'),
          'state'=> request('state'),
          'category_id'=> request('category_id'),
          'serie_id'=> request('serie_id'),
        ]);

        return Response::json(['message' => 'Product inserted'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $product = Product::findOrFail($id);

      $product->category;
      $product->serie;
      $product->productcolors;
      $product->productoptions;

      return Response::json($product, 200);
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
            'name'  => 'required|min:3|unique:products,name,'. $request->id,
            'serie_id'  => 'required',
            'category_id'  => 'required',
            'order' => 'integer',
        ];

        $this->validate($request,$rules);

        $product = Product::findOrFail($id);

        $product->name = request('name');
        $product->shortDesc = request('shortDesc');
        $product->longDesc = request('longDesc');
        $product->imgs = request('imgs');
        $product->links = request('links');
        $product->tags = request('tags');
        $product->order = request('order');
        $product->state = request('state');
        $product->category_id = request('category_id');
        $product->serie_id = request('serie_id');

        $product->save();

        return Response::json(['message' => 'Product well updated!'], 200);
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
