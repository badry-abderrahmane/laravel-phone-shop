@extends('layouts.main')

@section('stylesheets')

@endsection

@section('title')
  Galleries<small>Manager</small>
@endsection

@section('content')

        @component('components.panel')
          @slot('heading')
            Galleries List
          @endslot
          @slot('body')
            <galleries-list></galleries-list>
          @endslot
        @endcomponent


    @component('components.modal')
      @slot('id')
        modal-form
      @endslot
      @slot('title')
        Add new gallery
      @endslot
      @slot('body')
        <galleries-form></galleries-form>
      @endslot
    @endcomponent
@endsection

@section('scripts')

@endsection
