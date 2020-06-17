@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-10">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">{{ $cinema->name }}: {{ $hall->name }}. Мест в зале: {{ $hall->seats }} </div>
                    <div class="card-body">
                        <show-hall-component hall="{{ $hall->map }}"></show-hall-component>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <form action="{{ route('hall.update', [
                'cinema' => $cinema->id,
                'hall'   => $hall->id
            ]) }}" method="post">
                @method('PUT')
                @csrf
                <div class="input-group">
                    <label class="input-group-text" for="status">Options</label>
                    <select class="custom-select" id="status" name="status">
                        @if($hall->status === null)
                            <option selected>Выберите...</option>
                        @endif
                        @if($hall->status === 0)
                            <option value="0" selected>Закрыт</option>
                        @else
                            <option value="0">Закрыт</option>
                        @endif
                        @if($hall->status == 1)
                            <option value="1" selected>Открыт</option>
                        @else
                            <option value="1">Открыт</option>
                        @endif
                    </select>
                </div>
                <input type="submit" class="btn btn-primary" value="Сохранить">
            </form>
            <form action="{{ route('hall.destroy', [
                'cinema' => $cinema->id,
                'hall'   => $hall->id
            ]) }}" method="post">
                @method('DELETE')
                @csrf
                <input type="submit" class="btn btn-danger" value="Удалить зал">
            </form>
        </div>
    </div>

@endsection