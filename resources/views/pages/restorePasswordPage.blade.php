@extends('layouts.layout')

@section('title')
    Восстановление пароля
@endsection
@section('content')
    <restore-password-page
        :prop_breadcrumbs='{!! json_encode($breadcrumbs) !!}'
    ></restore-password-page>
@endsection
