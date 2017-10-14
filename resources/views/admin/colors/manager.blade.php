@extends('layouts.main')

@section('stylesheets')

@endsection

@section('title')
  Colors<small>Manager</small>
@endsection

@section('content')

        @component('components.panel')
          @slot('heading')
            Colors List
          @endslot
          @slot('body')
            <colors-list></colors-list>
          @endslot
        @endcomponent


    @component('components.modal')
      @slot('id')
        modal-form
      @endslot
      @slot('title')
        Add new color
      @endslot
      @slot('body')
        <colors-form></colors-form>
      @endslot
    @endcomponent
@endsection

@section('scripts')

@endsection
