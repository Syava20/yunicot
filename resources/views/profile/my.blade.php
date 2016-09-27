@extends('layouts.app')

@section('content')
    <p>Имя: {{ Auth::user()->firstName }}</p>
    <p>Фамилия: {{ Auth::user()->lastName }}</p>
    <p>Пол: {{ Auth::user()->sex == 0 ? 'Муж' : 'Жен' }}</p>
    <p>Email: {{ Auth::user()->email }}</p>
    <p><a href="{{ url('/'.Auth::user()->id.'/edit') }}">Редактировать</a></p>
@endsection