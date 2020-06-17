@extends('layouts.app')

@section('content')
    <new-hall-component cinema="{{ $cinema_name }}" places="{{ $places }}" id="{{ $cinema_id }}"></new-hall-component>
@endsection