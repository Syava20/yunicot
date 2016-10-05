@extends('layouts.app')

@section('content')
    <form action="{{ url('/'.Auth::user()->id.'/edit') }}" method="post">
        {{ csrf_field() }}
        <p>Имя:
            <input type="text" name="firstName" value="{{ old('firstName') ? old('firstName') : Auth::user()->firstName }}">
            <span>{{ $errors->has('firstName') ? $errors->first('firstName') : '' }}</span>
        </p>
        <p>Фамилия:
            <input type="text" name="lastName" value="{{ old('lastName') ? old('lastName') : Auth::user()->lastName }}">
            <span>{{ $errors->has('lastName') ? $errors->first('lastName') : '' }}</span>
        </p>

        <p>Email:
            <input type="text" name="email" value="{{ old('email') ? old('email') : Auth::user()->email  }}">
            <span>{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
        </p>
        <p>Пол:
            Муж <input type="radio" name="sex" value="0" {{ old('sex') == 0 ? 'checked' : Auth::user()->sex == 0 ? 'checked' : '' }}>
            Жен <input type="radio" name="sex" value="1" {{ old('sex') == 1 ? 'checked' : Auth::user()->sex == 1 ? 'checked' : '' }}>
            <span>{{ $errors->has('sex') ? $errors->first('sex') : '' }}</span>
        </p>
        <p>
            Пароль: <input type="password" name="password">
            <span>{{ $errors->has('password') ? $errors->first('password') : '' }}</span> <br />
            Повторите пароль: <input type="password" name="password_confirmation">
        </p>
        <button type="submit">
            Сохранить
        </button>

    </form>
@endsection