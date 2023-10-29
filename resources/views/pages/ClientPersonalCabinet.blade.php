@extends('layouts.layout')

@section('title')
    Личный кабинет клиента
@endsection
@section('content')
    <personal-cabinet-client
        :data_client='{!! json_encode($dataClient) !!}'
        :cities='{!! json_encode($cities) !!}'
        :requests='{!! json_encode($my_requests) !!}'
    >
    </personal-cabinet-client>
@endsection
