@extends('layouts.main')

@section('stylesheets')

@endsection

@section('title')
  Products<small>Manager</small>
@endsection

@section('content')

        @component('components.panel')
          @slot('heading')
            Products List
          @endslot
          @slot('body')
            <products-list></products-list>
          @endslot
        @endcomponent


    @component('components.modal')
      @slot('id')
        modal-form
      @endslot
      @slot('title')
        Add new product
      @endslot
      @slot('body')
        <products-form></products-form>
      @endslot
    @endcomponent

    @component('components.modal')
      @slot('id')
        modal-product-options
      @endslot
      @slot('title')
        Product options
      @endslot
      @slot('body')
        <product-options></product-options>
      @endslot
    @endcomponent
@endsection

@section('scripts')

@endsection
