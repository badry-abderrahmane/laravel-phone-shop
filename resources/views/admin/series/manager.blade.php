@extends('admin.layouts.main')

@section('stylesheets')

@endsection

@section('title')
  Series<small>Manager</small>
@endsection

@section('content')

        @component('components.panel')
          @slot('heading')
            Series List
          @endslot
          @slot('body')
            <series-list></series-list>
          @endslot
        @endcomponent


    @component('components.modal')
      @slot('id')
        modal-form
      @endslot
      @slot('title')
        Add new serie
      @endslot
      @slot('body')
        <series-form></series-form>
      @endslot
    @endcomponent
@endsection

@section('scripts')

@endsection
