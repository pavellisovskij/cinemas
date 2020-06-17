@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <create-session-common-component :cinemas="{{ $cinemas }}"></create-session-common-component>
    </div>
@endsection