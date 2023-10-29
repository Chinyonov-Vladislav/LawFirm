@extends('layouts.layout')

@section('title')
    Главная страница
@endsection
@section('content')
    <main-page :specializations='{!! json_encode($specializations) !!}'
                :news='{!! json_encode($news) !!}'
    ></main-page>
@endsection
