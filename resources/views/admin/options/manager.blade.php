@extends('layouts.main')

@section('stylesheets')

@endsection

@section('title')
  Options<small>Manager</small>
@endsection

@section('content')

        @component('components.panel')
          @slot('heading')
            Options List
          @endslot
          @slot('body')
            <options-list></options-list>
          @endslot
        @endcomponent


    @component('components.modal')
      @slot('id')
        modal-form
      @endslot
      @slot('title')
        Add new option
      @endslot
      @slot('body')
        <options-form></options-form>
      @endslot
    @endcomponent
@endsection

@section('scripts')

@endsection
