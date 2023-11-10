@extends('layouts.layout')

@section('title')
    Смена пароля
@endsection
@section('content')
    <change-password-page
        :email ='{!! json_encode($email) !!}'
    ></change-password-page>
@endsection
