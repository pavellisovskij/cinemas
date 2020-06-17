@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h5 class="card-title">{{ $cinema->name }}</h5>
            </div>
            <div class="card-body">
                <p class="card-text">
                    {{ $cinema->description }}
                </p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    {{ $cinema->address->country . ', ' . $cinema->address->city . ', ' . $cinema->address->street }}
                </li>
                <li class="list-group-item">
                    {{ $cinema->address->phone }}
                </li>
                <li class="list-group-item">
                    <a href="{{ route('cinema.edit', ['id' => $cinema->id]) }}" class="btn btn-primary">Редактировать</a>
                    <form action="{{ route('cinema.destroy', ['id' => $cinema->id]) }}" method="POST" style="display: inline-block">
                        @csrf
                        @method('DELETE')
                        <input class="btn btn-danger" type="submit" value="Удалить">
                    </form>
                </li>
            </ul>
            <div class="card-body">
                @if (session('success-hall-deleting'))
                    <div class="alert alert-success">
                        {{ session('success-hall-deleting') }}
                    </div>
                @endif
                <div class="list-group">
                    @if(!$cinema->hall->isEmpty())
                        @foreach($cinema->hall as $hall)
                            <a href="{{ route('hall.show', [$cinema->id, $hall->id]) }}" class="list-group-item list-group-item-action">{{ $hall->name }}</a>
                        @endforeach
                    @endif
                    <a href="{{ route('hall.create', $cinema->id) }}" class="list-group-item list-group-item-action list-group-item-primary">Добавить кинозал</a>
                </div>
            </div>
        </div>
    </div>
@endsection