@extends('layouts.app')

@section('content')
    <div class="container-fluid">
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
                <h4 class="card-title">{{ $film->name }}</h4>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-description-tab" data-toggle="tab" href="#nav-description" role="tab" aria-controls="nav-description" aria-selected="true">Описание</a>
                        <a class="nav-item nav-link" id="nav-cinemas-tab" data-toggle="tab" href="#nav-cinemas" role="tab" aria-controls="nav-cinemas" aria-selected="false">Назначить кинотеатрам</a>
                    </div>
                </nav>
            </div>
            <div class="card-body">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab">
                        <div class="row">
                            <div class="col-lg-3">
                                <img src="{{ asset('/storage/' . $film->poster) }}" class="card-img">
                            </div>
                            <div class="col-lg-9">
                                <form action="{{ route('film.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Название:</label>
                                        <input type="text" name="name" class="form-control" id="name" value="{{ $film->name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Описание:</label>
                                        <textarea name="description" class="form-control" id="description" required>{{ $film->description }}</textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="year">Год:</label>
                                                <input type="number" name="year" value="{{ $film->year }}" class="form-control" id="year" min="1895" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="duration">Длительность:</label>
                                                <input type="number" value="{{ $film->duration }}" name="duration" class="form-control" id="duration" min="0" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="start">Старт показа:</label>
                                                <input type="date" value="{{ $film->start }}" name="start" class="form-control" id="start" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="end">Конец показа:</label>
                                                <input type="date" value="{{ $film->end }}" name="end" class="form-control" id="end" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="price">Стоимость:</label>
                                                <input type="number" value="{{ $film->price }}" name="price" class="form-control" id="price" min="0.0" step="0.01" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="trailer">Ссылка на трейлер:</label>
                                                <input type="text" value="{{ $film->trailer }}" name="trailer" class="form-control" id="trailer">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="poster">Постер:</label>
                                        <input type="file" accept="image/*" name="poster" id="poster">
                                    </div>

                                    <div class="input-group-prepend">
                                        <input class="btn btn-primary" type="submit" value="Добавить">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-cinemas" role="tabpanel" aria-labelledby="nav-cinemas-tab">
                        <movie-to-cinema-component price="{{ $film->price }}" filmid="{{ $film->id }}"></movie-to-cinema-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection