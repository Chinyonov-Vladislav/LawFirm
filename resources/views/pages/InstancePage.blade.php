@extends('layouts.layout')

@section('title')
    Страница дела
@endsection
@section('content')
    <instance-page :info_case =' {!! json_encode($data_about_instance) !!}'
                   :prop_breadcrumbs='{!! json_encode($breadcrumbs) !!}'
    ></instance-page>
@endsection
