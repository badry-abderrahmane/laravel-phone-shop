@extends('admin.layouts.main')

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
        <products-list serieid="{{ $id }}"></products-list>
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
        <products-form serieid="{{ $id }}"></products-form>
      @endslot
    @endcomponent
@endsection

@section('scripts')

@endsection
