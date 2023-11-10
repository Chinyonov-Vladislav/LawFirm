@extends('layouts.layout')

@section('title')
    Услуги
@endsection
@section('content')
    <services-page
        :specializations='{!! json_encode($all_specializations) !!}'
        :services='{!! json_encode($services) !!}'
        :lawyers='{!! json_encode($all_lawyers) !!}'
        :all_min_cost='{!! json_encode($all_min_cost) !!}'
        :all_max_cost='{!! json_encode($all_max_cost) !!}'
        :prop_breadcrumbs ='{!! json_encode($breadcrumbs) !!}'
    ></services-page>
@endsection
