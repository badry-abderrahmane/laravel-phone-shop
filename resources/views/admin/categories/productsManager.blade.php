@extends('admin.layouts.main')

@section('stylesheets')

@endsection

@section('title')
  Products<small>Manager</small>
@endsection

@section('content')
    <products-list categoryid="{{ $id }}"></products-list>
@endsection

@section('scripts')

@endsection
