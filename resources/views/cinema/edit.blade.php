@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                Добавление нового кинотеатра
            </div>
            <div class="card-body">
                <form action="{{ route('cinema.update', ['id' => $cinema->id]) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="name">Название:</label>
                        <input type="text" value="{{ $cinema->name }}" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Описание:</label>
                        <textarea name="description" class="form-control" id="description" required>{{ $cinema->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="longitude">Долгота:</label>
                        <input type="text" value="{{ $cinema->address->longitude }}" name="longitude" class="form-control" id="longitude" required>
                    </div>
                    <div class="form-group">
                        <label for="latitude">Ширина:</label>
                        <input type="text" value="{{ $cinema->address->latitude }}" name="latitude" class="form-control" id="latitude" required>
                    </div>
                    <div class="form-group">
                        <label for="country">Страна:</label>
                        <input type="text" value="{{ $cinema->address->country }}" name="country" class="form-control" id="country" required>
                    </div>
                    <div class="form-group">
                        <label for="city">Город:</label>
                        <input type="text" value="{{ $cinema->address->city }}" name="city" class="form-control" id="city" required>
                    </div>
                    <div class="form-group">
                        <label for="street">Улица:</label>
                        <input type="text" value="{{ $cinema->address->street }}" name="street" class="form-control" id="street" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Телефон:</label>
                        <input type="tel" value="{{ $cinema->address->phone }}" name="phone" class="form-control" id="phone" required>
                    </div>
                    <div class="input-group-prepend">
                        <input class="btn btn-primary" type="submit" value="Сохранить изменения">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection