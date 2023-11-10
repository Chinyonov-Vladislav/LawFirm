@extends('layouts.layout')

@section('title')
    Личный кабинет адвоката
@endsection
@section('content')
    <personal-cabinet-lawyer
        :lawyer_data = '{!! json_encode($dataLawyer) !!}'
        :instances_lawyer = '{!! json_encode($instances_lawyer) !!}'
        :prop_breadcrumbs='{!! json_encode($breadcrumbs) !!}'
        :prop_instances_counts='{!! json_encode($instances_counts) !!}'
        :prop_moneys_by_cases='{!! json_encode($moneys_by_cases) !!}'
        :prop_count_cases_by_rating='{!! json_encode($instances_counts_by_rating) !!}'
        :prop_news='{!! json_encode($news) !!}'
    >
    </personal-cabinet-lawyer>
@endsection
