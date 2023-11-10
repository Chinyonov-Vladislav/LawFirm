@extends('layouts.layout')

@section('title')
    Адвокат
@endsection
@section('content')
    <lawyer-page :prop_lawyer_info='{!! json_encode($lawyer_info) !!}'
                :prop_breadcrumbs='{!! json_encode($breadcrumbs) !!}'
                 :prop_lawyer_instances_percentages='{!! json_encode($lawyer_instances_percentages) !!}'
    ></lawyer-page>
@endsection
