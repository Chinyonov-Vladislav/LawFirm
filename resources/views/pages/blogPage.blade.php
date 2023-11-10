@extends('layouts.layout')

@section('title')
    Блог
@endsection
@section('content')
    <blog-page :news='{!! json_encode($news) !!}'
                :prop_breadcrumbs ='{!! json_encode($breadcrumbs) !!}'
               :prop_all_count_news='{!! json_encode($all_count_news) !!}'
    ></blog-page>
@endsection
