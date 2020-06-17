@extends('layouts.app')

@section('content')
    <div class="container">
        @if(!$places->isEmpty())
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Наименование</th>
                        <th scope="col">Цена</th>
                        <th scope="col">Опции</th>
                        <th scope="col">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($places as $place)
                        <tr>
                            <th scope="row">1</th>
                            <td>{{ $place->name }}</td>
                            <td>{{ $place->amount }}</td>
                            <td>
                                <ul class="list-group">
                                    @foreach($place->options as $option)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $option->name }}
                                            <span class="badge badge-primary badge-pill">{{ $option->cost }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <form action="{{ route('place.destroy', $place->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <input type="submit" class="btn btn-danger" value="Удалить">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-secondary" role="alert">
                Пока что нет мест. Добавьте места.
            </div>
        @endif
    </div>
@endsection