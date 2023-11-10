@extends('layouts.layout')

@section('title')
    Наши специализации
@endsection
@section('content')
    <all-specializations-page
        :prop_breadcrumbs='{!! json_encode($breadcrumbs) !!}'
        :prop_specializations='{!! json_encode($specializations) !!}'
    ></all-specializations-page>
@endsection
