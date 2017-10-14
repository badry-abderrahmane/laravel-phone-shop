@extends('layouts.main')

@section('stylesheets')

@endsection

@section('title')
  Accessories<small>Manager</small>
@endsection

@section('content')

        @component('components.panel')
          @slot('heading')
            Accessories List
          @endslot
          @slot('body')
            <accessories-list></accessories-list>
          @endslot
        @endcomponent


    @component('components.modal')
      @slot('id')
        modal-form
      @endslot
      @slot('title')
        Add new accessory
      @endslot
      @slot('body')
        <accessories-form></accessories-form>
      @endslot
    @endcomponent
@endsection

@section('scripts')

@endsection
