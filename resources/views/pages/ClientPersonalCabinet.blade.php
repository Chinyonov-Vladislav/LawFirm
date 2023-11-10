@extends('layouts.layout')

@section('title')
    Личный кабинет клиента
@endsection
@section('content')
    <personal-cabinet-client
        :data_client='{!! json_encode($dataClient) !!}'
        :cities='{!! json_encode($cities) !!}'
        :requests='{!! json_encode($my_requests) !!}'
        :instances='{!! json_encode($my_instances) !!}'
        :prop_breadcrumbs='{!! json_encode($breadcrumbs) !!}'
    >
    </personal-cabinet-client>
@endsection
