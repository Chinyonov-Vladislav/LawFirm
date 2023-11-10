@extends('layouts.layout')

@section('title')
    Наши адвокаты
@endsection
@section('content')
    <lawyers-page :lawyers='{!! json_encode($lawyers) !!}'
                  :specializations='{!! json_encode($all_specializations) !!}'
                  :prop_breadcrumbs='{!! json_encode($breadcrumbs) !!}'
    ></lawyers-page>
@endsection
