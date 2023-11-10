@extends('layouts.layout')

@section('title')
    Авторизация
@endsection
@section('content')
    <login-page
        :prop_breadcrumbs='{!! json_encode($breadcrumbs) !!}'
    ></login-page>
@endsection
