<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

use App\Category;

class CategoryController extends Controller
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
      $categories = Category::All();
      return Response::json($categories, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.manager');
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
          'desc'  => '',
          'order' => 'integer',
      ];

      $this->validate($request,$rules);

      Category::forceCreate([
        'name' => request('name'),
        'desc'  => request('desc'),
        'order' => request('order')
      ]);

      return Response::json(['message' => 'Category inserted'], 200);
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
          'name'  => 'required|min:3|unique:categories,name,'. $request->id,
          'order' => 'integer',
      ];

      $this->validate($request,$rules);

      $category = Category::findOrFail($id);

      $category->name = request('name');
      $category->desc = request('desc');
      $category->order = request('order');
      $category->state = request('state');

      $category->save();

      return Response::json(['message' => 'Category well updated!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $var = Category::destroy($id);
      return Response::json($var, 200);
    }
}
