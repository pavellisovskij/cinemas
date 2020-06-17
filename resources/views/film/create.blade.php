@extends('layouts.app')

@section('content')
    <div class="container">

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (session('film_exists'))
            <div class="alert alert-warning">
                {{ session('film_exists') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                Добавление нового кинотеатра
            </div>
            <div class="card-body">
                <form action="{{ route('film.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Название:</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Описание:</label>
                        <textarea name="description" class="form-control" id="description" required>{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="year">Год:</label>
                        <input type="number" name="year" value="{{ old('year') ? old('year') : date('Y') }}" class="form-control" id="year" min="1895" required>
                    </div>
                    <div class="form-group">
                        <label for="duration">Длительность:</label>
                        <input type="number" value="{{ old('duration') }}" name="duration" class="form-control" id="duration" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="start">Старт показа:</label>
                        <input type="date" value="{{ old('start') }}" name="start" class="form-control" id="start" required>
                    </div>
                    <div class="form-group">
                        <label for="end">Конец показа:</label>
                        <input type="date" value="{{ old('end') }}" name="end" class="form-control" id="end" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Стоимость:</label>
                        <input type="number" value="{{ old('price') }}" name="price" class="form-control" id="price" min="0.0" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="trailer">Ссылка на трейлер:</label>
                        <input type="text" value="{{ old('trailer') }}" name="trailer" class="form-control" id="trailer">
                    </div>

                    <div class="form-group">
                        <label for="poster">Постер:</label>
                        <input type="file" value="{{ old('poster') }}" accept="image/*" name="poster" id="poster" required>
                    </div>

                    <div class="input-group-prepend">
                        <input class="btn btn-primary" type="submit" value="Добавить">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection