@extends('admin.layouts.main')

@section('stylesheets')

@endsection

@section('title')
  Product<small>options</small>
@endsection

@section('content')
      @component('components.panel')
        @slot('heading')
          General informations
        @endslot
        @slot('body')
          <div class="row">
            <div class="col-md-3">
              <label for="name">Name</label>
              <p name="name">{{ $product->name}}</p>
            </div>
            <div class="col-md-3">
              <label for="name">Category</label>
              <p name="name">{{ $product->category->name}}</p>
            </div>
            <div class="col-md-3">
              <label for="name">Serie</label>
              <p name="name">{{ $product->serie->name}}</p>
            </div>
            <div class="col-md-2">
              <label for="name">State</label>
              <p name="name">{{ $product->state}}</p>
            </div>
            <div class="col-md-1">
              <label for="name">Order</label>
              <p name="name">{{ $product->order}}</p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <label for="name">Links</label>
              <p name="name">{{ $product->links}}</p>
            </div>
            <div class="col-md-3">
              <label for="name">Images</label>
              <p name="name">{{ $product->imgs}}</p>
            </div>
            <div class="col-md-3">
              <label for="name">Short description</label>
              <p name="name">{{ $product->shortDesc}}</p>
            </div>
            <div class="col-md-3">
              <label for="name">Long description</label>
              <p name="name">{{ $product->shortDesc}}</p>
            </div>
          </div>

        @endslot
      @endcomponent
      <div class="row">
        <div class="col-md-6">
          @component('components.panel')
            @slot('heading')
              Options
            @endslot
            @slot('body')
              <div class="row">
                <div class="col-md-12">
                  <product-options productoptions="{{ $product->productoptions }}"></product-options>
                </div>
              </div>
            @endslot
          @endcomponent
        </div>
        <div class="col-md-6">
          @component('components.panel')
            @slot('heading')
              Colors
            @endslot
            @slot('body')
              <div class="row">
                <div class="col-md-12">
                  <product-colors productcolors="{{ $product->productcolors }}" id="{{ $product->id }}"></product-colors>
                </div>
              </div>
            @endslot
          @endcomponent
        </div>
      </div>




@endsection

@section('scripts')

@endsection
