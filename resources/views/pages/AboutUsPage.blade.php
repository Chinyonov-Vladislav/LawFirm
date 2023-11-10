@extends('layouts.layout')

@section('title')
    О нас
@endsection
@section('content')
    <about-page
        :prop_breadcrumbs='{!! json_encode($breadcrumbs) !!}'
        :prop_common_count_instances='{!! json_encode($common_count_instances) !!}'
        :prop_winner_instances='{!! json_encode($winner_instances) !!}'
        :prop_count_lawyers='{!! json_encode($count_lawyers) !!}'
        :prop_count_clients='{!! json_encode($count_clients) !!}'
    ></about-page>
@endsection
