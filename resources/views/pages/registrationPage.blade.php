@extends('layouts.layout')

@section('title')
    Регистрация
@endsection
@section('content')
    <registration-page
        :prop_breadcrumbs='{!! json_encode($breadcrumbs) !!}'
    ></registration-page>
@endsection
