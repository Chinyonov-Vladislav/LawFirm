@extends('layouts.layout')

@section('title')
    Новость
@endsection
@section('content')
    <article-page :article='{!! json_encode($current_article) !!}'
                  :can_redact='{!! json_encode($can_redact) !!}'
                  :prop_breadcrumbs='{!! json_encode($breadcrumbs) !!}'
    ></article-page>
@endsection
