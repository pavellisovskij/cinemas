@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(!$cinemas->isEmpty())
            <div class="row row-cols-1 row-cols-md-3">
                @foreach($cinemas as $cinema)
                    <div class="col mb-4">
                        <div class="card">
                            <a href="{{ route('cinema.show', $cinema->id) }}" class="card-link">
                                <div class="card-header text-center">
                                    {{ $cinema->name }}
                                </div>
                            </a>
                            <div class="card-body">
                                <div class="list-group">
                                    @if(!$cinema->hall->isEmpty())
                                        @foreach($cinema->hall as $hall)
                                            <a href="{{ route('hall.show', [$cinema->id, $hall->id]) }}" class="list-group-item list-group-item-action">{{ $hall->name }}</a>
                                        @endforeach
                                    @endif
                                        <a href="{{ route('hall.create', $cinema->id) }}" class="list-group-item list-group-item-action list-group-item-primary">Добавить зал</a>
                                </div>
                            </div>
                            <div class="card-footer">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item" style="background: transparent">
                                        {{ $cinema->address->country . ', ' . $cinema->address->city . ', ' . $cinema->address->street }}
                                    </li>
                                    <li class="list-group-item" style="background: transparent">{{ $cinema->address->phone }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-secondary" role="alert">
                Пока что нет ни одного кинотеатра.
            </div>
        @endif
    </div>
@endsection