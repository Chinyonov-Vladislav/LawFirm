@extends('layouts.layout')

@section('title')
    Ошибка
@endsection
@section('content')
    <general-error-page :text_error='{!! json_encode($text_error) !!}'></general-error-page>
@endsection
