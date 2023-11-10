@extends('layouts.layout')

@section('title')
    Отзывы о нас
@endsection
@section('content')
    <reviews-page   :prop_reviews='{!! json_encode($reviews) !!}'
                    :prop_average_rating ='{!! json_encode($average_rating) !!}'
                    :prop_scores='{!! json_encode($scores) !!}'
                    :prop_breadcrumbs='{!! json_encode($breadcrumbs) !!}'
    >

    </reviews-page>
@endsection
