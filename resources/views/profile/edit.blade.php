@extends('layouts.app')

@section('content')
    <form action="{{ url('/'.Auth::user()->id.'/edit') }}" method="post">
        <p>Имя: <input type="text" value="{{ Auth::user()->firstName }}"></p>
        <p>Фамилия: <input type="text" value="{{ Auth::user()->lastName }}"></p>
        <p>Имя: <input type="text" value="{{ Auth::user()->firstName }}"></p>

    </form>
    <p>Пол: {{ Auth::user()->sex == 0 ? 'Муж' : 'Жен' }}</p>
    <p>Email: {{ Auth::user()->email }}</p>
    <p><a href="{{ url('/'.Auth::user()->id.'/edit') }}">Редактировать</a></p>
@endsection