@extends('admin.layouts.main')

@section('stylesheets')

@endsection

@section('title')
  Option groups<small>Manager</small>
@endsection

@section('content')

        @component('components.panel')
          @slot('heading')
            Option groups List
          @endslot
          @slot('body')
            <optiongroups-list></optiongroups-list>
          @endslot
        @endcomponent


    @component('components.modal')
      @slot('id')
        modal-form
      @endslot
      @slot('title')
        Add new option group
      @endslot
      @slot('body')
        <optiongroups-form></optiongroups-form>
      @endslot
    @endcomponent
@endsection

@section('scripts')

@endsection
