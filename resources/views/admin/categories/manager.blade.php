@extends('admin.layouts.main')

@section('stylesheets')

@endsection

@section('title')
  Categories<small>Manager</small>
@endsection

@section('content')

        @component('components.panel')
          @slot('heading')
            Categories List
          @endslot
          @slot('body')
            <categories-list></categories-list>
          @endslot
        @endcomponent


    @component('components.modal')
      @slot('id')
        modal-form
      @endslot
      @slot('title')
        Add new category
      @endslot
      @slot('body')
        <categories-form></categories-form>
      @endslot
    @endcomponent
@endsection

@section('scripts')

@endsection
