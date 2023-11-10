@extends('layouts.layout')

@section('title')
    Часто задаваемые вопросы
@endsection
@section('content')
    <faq-page
        :prop_breadcrumbs='{!! json_encode($breadcrumbs) !!}'
    ></faq-page>
@endsection
