@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @foreach($films as $film)
        <div class="card">
            <div class="card-header">{{ $film->name }}</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach($film->sessions as $session)
                        <li class="list-group-item" style="background: transparent">
                            {{ $session->date }} {{ $session->time }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <br>
    @endforeach
    
    <div class="row">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">{{ $cinema->name }}: {{ $hall->name }}. Мест в зале: {{ $hall->seats }} </div>
                <div class="card-body">
                    <show-hall-component hall="{{ $hall->map }}"></show-hall-component>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            @if($hall->status === null)
                Статус: ожидание.
            @elseif($hall->status == false)
                Статус: закрыт.
            @elseif($hall->status == true)
                Статус: открыт.
            @endif
            <a href="{{ route('hall.edit', [
                'cinema' => $cinema->id,
                'hall'   => $hall->id
            ]) }}" class="btn btn-primary">Редактировать</a>
        </div>
    </div>
@endsection