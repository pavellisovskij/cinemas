@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ $film->name }}</h4>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-description-tab" data-toggle="tab" href="#nav-description" role="tab" aria-controls="nav-description" aria-selected="true">Описание</a>
                        @if(!empty($film->trailer))
                            <a class="nav-item nav-link" id="nav-trailer-tab" data-toggle="tab" href="#nav-trailer" role="tab" aria-controls="nav-trailer" aria-selected="false">Трейлер</a>
                        @endif
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
                                <h4 class="card-title">{{ $film->name }}</h4>
                                <p class="card-text"><b>Год:</b> {{ $film->year }}</p>
                                <p class="card-text"><b>Длительность:</b> {{ $film->duration }} мин.</p>
                                <p class="card-text"><b>Период показа:</b> с {{ \Illuminate\Support\Facades\Date::parse($film->start)->format('d.m.Y') }} по {{ \Illuminate\Support\Facades\Date::parse($film->end)->format('d.m.Y') }}</p>
                                <p class="card-text"><b>Сборы:</b> </p>
                                <p class="card-text"><b>Цена за билет:</b> {{ $film->price }}</p>
                                <p class="card-text">{{ $film->description }}</p>
                                <p class="card-text"><small class="text-muted">Обновлено: {{ $film->updated_at }}</small></p>
                            </div>
                        </div>
                    </div>
                    @if(!empty($film->trailer))
                        <div class="tab-pane fade" id="nav-trailer" role="tabpanel" aria-labelledby="nav-trailer-tab">
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $film->trailer }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('film.edit', $film->id) }}" class="btn btn-primary">Редактировать</a>
            </div>
        </div>
    </div>
@endsection