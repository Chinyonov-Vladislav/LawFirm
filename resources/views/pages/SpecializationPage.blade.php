@extends('layouts.layout')

@section('title')
    Специализация
@endsection
@section('content')
    <specialization-page :spec_info='{!! json_encode($instancesData) !!}'
                        :basic_spec_info='{!! json_encode($basic_info_specialization) !!}'
                         :lawyers='{!! json_encode($lawyers_in_specialization) !!}'
                         :services='{!! json_encode($services_in_specialization) !!}'
                         :prop_breadcrumbs='{!! json_encode($breadcrumbs) !!}'
    ></specialization-page>
@endsection
