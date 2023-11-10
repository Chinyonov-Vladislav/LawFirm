@extends('layouts.layout')

@section('title')
    Главная страница
@endsection
@section('content')
    <main-page :specializations='{!! json_encode($specializations) !!}'
               :news='{!! json_encode($news) !!}'
               :common_count_instances='{{ json_encode($common_count_instances) }}'
               :winner_instances='{{ json_encode($winner_instances) }}'
               :prop_count_lawyers='{!! json_encode($count_lawyers) !!}'
               :prop_count_clients='{!! json_encode($count_clients) !!}'
    ></main-page>
@endsection
